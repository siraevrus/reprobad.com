<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\Config;
use App\Models\ChatHistory;

class BotService {
    protected $keyId;
    protected $secret;
    protected $projectId;
    protected $kbUrl;
    protected $ragVersion;
    protected $systemPrompt;
    protected $model;
    protected $historyLimit = 10; // Количество сообщений в контексте

    public function __construct()
    {
        $this->ragVersion  = '180693d5-c042-41bb-8a8f-74422a829438';
        $this->kbUrl       = 'https://f680f317-34d6-4e97-b33a-3517420876fc.managed-rag.inference.cloud.ru/api/v2/retrieve_generate';
        $this->model       = "t-tech/T-pro-it-2.0";
        $this->setSysPromt();
    }
    
    protected function setSysPromt()
    {
        $this->systemPrompt = Config::where('key', 'system_prompt')->first()->value;
        return true;
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

        // Формируем запрос с учетом истории
        $contextualQuery = $query;
        if ($history->isNotEmpty()) {
            $historyContext = $this->buildContextFromHistory($history);
            $contextualQuery = $historyContext . $query;
        }

        $data = [
            "query" => $contextualQuery,
            "knowledge_base_version" => $this->ragVersion,
            "retrieval_configuration" => [
                "number_of_results" => 20,
                "retrieval_type" => "SEMANTIC"
            ],
            "reranking_configuration" => [
                "model_name" => "Qwen/Qwen3-Reranker-0.6B",
                "model_source" => "FOUNDATION_MODELS",
                "number_of_reranked_results" => 20
            ],
            "generation_configuration" => [
                "model_name" => $this->model,
                "model_source" => "FOUNDATION_MODELS",
                "number_of_chunks_in_context" => 20,
                "temperature" => 0,
                "top_p" => 1,
                "system_prompt" => $this->systemPrompt,
            ]
        ];

        $response = $this->request($this->kbUrl, $data);

        $result = json_decode($response, true);

        // Сохраняем в историю, если есть userId и успешный ответ
        if ($userId && isset($result['llm_answer'])) {
            try {
                ChatHistory::create([
                    'user_id' => $userId,
                    'source' => $source,
                    'chat_id' => $source === 'telegram' ? $userId : null,
                    'user_message' => $query,
                    'bot_response' => $result['llm_answer'],
                ]);
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
}