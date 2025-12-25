<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\Config;
use App\Models\ChatHistory;
use App\Models\Product;

class BotService {
    protected $keyId;
    protected $secret;
    protected $projectId;
    protected $kbUrl;
    protected $systemPrompt;
    protected $model;
    protected $maxTokens;
    protected $temperature;
    protected $topP;
    protected $historyLimit = 3; // Количество сообщений в контексте

    public function __construct()
    {
        $configs = Config::whereIn('key', ['ai_model', 'system_prompt', 'max_tokens', 'temperature', 'top_p'])
            ->pluck('value', 'key');
        
        $this->kbUrl       = 'https://api.hydraai.ru/v1/chat/completions';
        $this->model       = $configs->get('ai_model') ?? 'deepseek-v3.2';
        $this->systemPrompt = $configs->get('system_prompt');
        $this->maxTokens   = (int)($configs->get('max_tokens') ?? 1000);
        $this->temperature = (float)($configs->get('temperature') ?? 0.8);
        $this->topP        = (float)($configs->get('top_p') ?? 0.9);
    }

    /**
     * Запрос к API
     */
    protected function request($url, $payload, $headers = [])
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => array_merge(["Content-Type: application/json"], $headers),
            CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ]);
        $response = curl_exec($ch);
        if ($response === false) {
            Log::error("CURL error: " . curl_error($ch));
            return '';
        }
        return $response;
    }

    // ============================================
    // РАЗДЕЛ: Поиск продуктов
    // ============================================

    /**
     * Морфологический поиск продуктов по запросу
     * Ищет в полях: title и ai_content
     * Использует поиск по словам с учетом разных форм
     */
    protected function searchProducts($query)
    {
        if (empty(trim($query))) {
            return collect();
        }

        $queryLower = mb_strtolower(trim($query));
        
        // Ключевые слова, указывающие на общий запрос о продуктах
        $productKeywords = ['продукт', 'продукты', 'товар', 'товары', 'бад', 'бады', 'препарат', 'препараты', 
                           'средств', 'средство', 'комплекс', 'комплексы', 'линейк', 'линейка'];
        
        // Проверяем, является ли запрос общим запросом о продуктах
        $isGeneralProductQuery = false;
        foreach ($productKeywords as $keyword) {
            if (mb_stripos($queryLower, $keyword) !== false) {
                $isGeneralProductQuery = true;
                break;
            }
        }
        
        // Если это общий запрос о продуктах, возвращаем все активные продукты
        if ($isGeneralProductQuery) {
            Log::info('General product query detected, returning all active products');
            return Product::active()
                ->limit(20) // Ограничиваем количество для промпта
                ->get();
        }

        // Разбиваем запрос на слова (убираем знаки препинания, приводим к нижнему регистру)
        $words = preg_split('/[\s,\.;:!?\-]+/u', $queryLower, -1, PREG_SPLIT_NO_EMPTY);
        
        // Фильтруем короткие слова и стоп-слова
        $words = array_filter($words, function($word) {
            $stopWords = ['как', 'что', 'где', 'когда', 'для', 'при', 'про', 'это', 'его', 'её', 'их', 'у', 'вас', 'есть', 'какие', 'расскажи', 'расскажите', 'о', 'об', 'такое', 'такой', 'такая', 'такие', 'таким', 'такими', 'такому', 'таком', 'такою', 'таков', 'такова', 'таково', 'таковы'];
            return mb_strlen($word) >= 2 && !in_array($word, $stopWords);
        });
        
        if (empty($words)) {
            return collect();
        }

        // Ищем продукты, где слова встречаются в полях title и ai_content
        // Используем OR для каждого слова, но приоритет отдаем продуктам с большим количеством совпадений
        $products = Product::active()
            ->where(function ($q) use ($words) {
                foreach ($words as $word) {
                    $searchTerm = '%' . $word . '%';
                    $q->orWhere(function ($subQuery) use ($searchTerm) {
                        $subQuery->where('title', 'LIKE', $searchTerm)
                            ->orWhere('ai_content', 'LIKE', $searchTerm);
                    });
                }
            })
            ->get()
            ->map(function ($product) use ($words) {
                // Подсчитываем количество совпадений для сортировки по релевантности
                $product->relevance_score = 0;
                $searchFields = [
                    $product->title,
                    $product->ai_content
                ];
                
                foreach ($words as $word) {
                    foreach ($searchFields as $field) {
                        if (!empty($field) && mb_stripos($field, $word) !== false) {
                            $product->relevance_score++;
                        }
                    }
                }
                
                return $product;
            })
            ->sortByDesc('relevance_score')
            ->take(10) // Берем топ-10 по релевантности
            ->values();

        return $products;
    }

    /**
     * Форматирование найденных продуктов для добавления в системный промпт
     */
    protected function formatProductsForPrompt($products)
    {
        if ($products->isEmpty()) {
            return '';
        }

        $text = "\n\n=== Информация о продуктах из базы данных ===\n\n";
        
        foreach ($products as $product) {
            $text .= "Продукт: " . ($product->title ?? 'Без названия') . "\n";
            
            // Используем ai_content если он есть, иначе только название
            if (!empty($product->ai_content)) {
                // Убираем HTML теги, но оставляем markdown форматирование
                $aiContent = strip_tags($product->ai_content);
                $text .= $aiContent . "\n";
            }
            
            $text .= "\n---\n\n";
        }

        $text .= "Используй эту информацию для ответа на вопросы пользователя о продуктах.\n";
        
        return $text;
    }

    // ============================================
    // РАЗДЕЛ: История бота
    // ============================================

    /**
     * Формирование контекста из истории чата
     */
    protected function buildContextFromHistory($history)
    {
        if ($history->isEmpty()) {
            return '';
        }

        $context = "\n\nИстория предыдущего диалога:\n";
        foreach ($history as $item) {
            $context .= "Пользователь: " . $item->user_message . "\n";
            $context .= "Ассистент: " . $item->bot_response . "\n";
        }
        $context .= "\nТекущий запрос:\n";

        return $context;
    }

    /**
     * Основной обработчик (чат с RAG и памятью)
     */
    public function handle($query, $userId = null, $source = 'web')
    {
        if (!$query) {
            return json_encode(['error' => 'Пустой запрос']);
        }

        // Получаем историю для пользователя
        $history = collect();
        if ($userId) {
            $history = ChatHistory::getRecentMessages($userId, $source, $this->historyLimit);
        }

        // Поиск продуктов по запросу пользователя
        $products = $this->searchProducts($query);
        $productsContext = $this->formatProductsForPrompt($products);
        
        // Логируем информацию о найденных продуктах
        Log::info('Products search result', [
            'query' => $query,
            'products_found' => $products->count(),
            'products_context_length' => strlen($productsContext)
        ]);
        
        // Формируем расширенный системный промпт с информацией о продуктах
        $enhancedSystemPrompt = $this->systemPrompt . $productsContext;
        
        // Логируем финальный промпт (первые 500 символов для отладки)
        Log::info('Enhanced system prompt', [
            'prompt_length' => strlen($enhancedSystemPrompt),
            'prompt_preview' => mb_substr($enhancedSystemPrompt, 0, 500) . '...'
        ]);

        // Формируем запрос с учетом истории
        $contextualQuery = $query;
        if ($history->isNotEmpty()) {
            $historyContext = $this->buildContextFromHistory($history);
            $contextualQuery = $historyContext . $query;
        }

        $apikey = "sk-hydra-ai-9Wa_xIkc31KS5__PlVJxvAXBiaeWM6rXbkjj+vtpCkajhU-_VMq8JyUQJ2XiUN2+";
        
        $headers = array(
            "Authorization: Bearer $apikey",
            "Content-Type: application/json"
        );
        
        $data = [
            "model" => $this->model,
            'messages' => [
                ['role' => 'system', 'content' => $enhancedSystemPrompt],
                ['role' => 'user', 'content' => $contextualQuery],
            ],
            "max_tokens" => $this->maxTokens,
            "temperature" => $this->temperature,
            "top_p" => $this->topP,
            "stream" => false
        ];

        $response = $this->request($this->kbUrl, $data, $headers);

        $result = json_decode($response, true);

        // Сохраняем в историю, если есть userId и успешный ответ
        if ($userId && isset($result['choices'][0]['message']['content'])) {
            try {
                ChatHistory::create([
                    'user_id' => $userId,
                    'source' => $source,
                    'chat_id' => $source === 'telegram' ? $userId : null,
                    'user_message' => $query,
                    'bot_response' => $result['choices'][0]['message']['content'],
                ]);

                // Автоочистка истории: оставляем только последние 3 записи для пользователя
                $deleted = ChatHistory::autoCleanUserHistory($userId, $source, 3);
                if ($deleted > 0) {
                    Log::info('Chat history auto-cleaned', [
                        'user_id' => $userId,
                        'source' => $source,
                        'deleted' => $deleted
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to save chat history: ' . $e->getMessage());
            }
        }

        return $result;
    }
    
    /**
     * Очистить историю для пользователя
     */
    public function clearHistory($userId, $source = 'web')
    {
        return ChatHistory::where('user_id', $userId)
            ->where('source', $source)
            ->delete();
    }
    
    function markdownToHtml($text) {
        $text = preg_replace("/(\r?\n){2,}/", "\n", $text);
        
        // Экранируем спецсимволы HTML
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        // Заголовки
        $text = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $text);
        $text = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $text);

        // Жирный **bold**
        $text = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $text);

        // Курсив *italic* (не перекрывает жирный)
        $text = preg_replace('/(?<!\*)\*(?!\*)(.*?)\*(?!\*)/s', '<em>$1</em>', $text);

        // Код `code`
        $text = preg_replace('/`([^`]+)`/', '<code>$1</code>', $text);

        // Ссылки [текст](url)
        $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2" target="_blank">$1</a>', $text);

        // Списки (обернём вручную в ul)
        $text = preg_replace_callback('/(?:^|\n)- (.+)(?:\n- .+)*/', function ($matches) {
            $items = explode("\n", trim($matches[0]));
            $list = "<ul>";
            foreach ($items as $item) {
                $list .= '<li>' . preg_replace('/^- /', '', trim($item)) . "</li>";
            }
            return $list . "</ul>";
        }, $text);

        return $text;
    }

    /**
     * Конвертация markdown в HTML для Telegram (поддерживает только ограниченный набор тегов)
     */
    function markdownToTelegramHtml($text) {
        $text = preg_replace("/(\r?\n){2,}/", "\n", $text);
        
        // Экранируем спецсимволы HTML
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        // Заголовки заменяем на жирный текст
        $text = preg_replace('/^### (.+)$/m', '<b>$1</b>', $text);
        $text = preg_replace('/^## (.+)$/m', '<b>$1</b>', $text);
        $text = preg_replace('/^# (.+)$/m', '<b>$1</b>', $text);

        // Жирный **bold** -> <b>
        $text = preg_replace('/\*\*(.*?)\*\*/s', '<b>$1</b>', $text);

        // Курсив *italic* -> <i>
        $text = preg_replace('/(?<!\*)\*(?!\*)(.*?)\*(?!\*)/s', '<i>$1</i>', $text);

        // Код `code` -> <code>
        $text = preg_replace('/`([^`]+)`/', '<code>$1</code>', $text);

        // Ссылки [текст](url) -> <a>
        $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $text);

        // Списки: заменяем на простой текст с символами
        $text = preg_replace_callback('/(?:^|\n)- (.+)(?:\n- .+)*/', function ($matches) {
            $items = explode("\n", trim($matches[0]));
            $list = "";
            foreach ($items as $item) {
                $list .= "• " . preg_replace('/^- /', '', trim($item)) . "\n";
            }
            return "\n" . trim($list);
        }, $text);

        return $text;
    }
}