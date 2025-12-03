<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Advise;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        // Если есть поисковый запрос, ищем в обоих разделах
        if ($request->get('query')) {
            $query = strtolower($request->get('query'));
            
            // Поиск в статьях по тексту
            $articles = Article::where('active', 1)
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                      ->orWhere('description', 'like', '%' . $query . '%')
                      ->orWhere('content', 'like', '%' . $query . '%');
                })
                ->get()
                ->map(function($item) {
                    $item->type = 'article';
                    $item->route_name = 'site.articles.show';
                    return $item;
                });
            
            // Поиск в советах по тексту
            $advises = Advise::where('active', 1)
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                      ->orWhere('description', 'like', '%' . $query . '%')
                      ->orWhere('content', 'like', '%' . $query . '%');
                })
                ->get()
                ->map(function($item) {
                    $item->type = 'advise';
                    $item->route_name = 'site.advises.show';
                    return $item;
                });
            
            // Поиск по категориям в статьях
            $articlesByCategory = Article::where('active', 1)
                ->whereNotNull('category')
                ->where('category', 'like', '%' . $query . '%')
                ->get()
                ->map(function($item) {
                    $item->type = 'article';
                    $item->route_name = 'site.articles.show';
                    return $item;
                });
            
            // Поиск по категориям в советах
            $advisesByCategory = Advise::where('active', 1)
                ->whereNotNull('category')
                ->where('category', 'like', '%' . $query . '%')
                ->get()
                ->map(function($item) {
                    $item->type = 'advise';
                    $item->route_name = 'site.advises.show';
                    return $item;
                });
            
            // Объединяем результаты по категориям (отдельно для блока "Похожие")
            $similarByCategory = $articlesByCategory->concat($advisesByCategory)
                ->sortByDesc('created_at')
                ->take(2)
                ->values();
            
            // Объединяем все результаты поиска (текст + категории, исключая дубликаты по alias)
            $allResources = $articles->concat($advises)
                ->concat($articlesByCategory)
                ->concat($advisesByCategory)
                ->unique(function($item) {
                    return $item->type . '_' . $item->alias;
                })
                ->sortByDesc('created_at')
                ->values();
            
            // Ручная пагинация
            $page = $request->get('page', 1);
            $perPage = 11;
            $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
            $items = $allResources->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $resources = new \Illuminate\Pagination\LengthAwarePaginator($items, $allResources->count(), $perPage, $currentPage, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        } else {
            // Обычный режим - только статьи
            $resources = Article::where('active', 1);

            // Фильтрация по категории
            if ($request->get('category')) {
                $resources = $resources->where('category', $request->get('category'));
            }

            $resources = $resources->orderBy('created_at', 'desc')->paginate(11);
        }

        // Получаем категории с подсчетом количества статей
        $allArticles = Article::where('active', 1)->get();
        $categories = Article::where('active', 1)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->map(function ($category) use ($allArticles) {
                return [
                    'name' => $category,
                    'count' => $allArticles->where('category', $category)->count()
                ];
            })
            ->values();

        // Формируем динамические SEO данные при фильтрации по категории и пагинации
        $category = $request->get('category');
        $forceDynamic = false;
        $currentPage = $resources->currentPage();
        $lastPage = $resources->lastPage();
        
        // Проверяем, есть ли пагинация (только если не первая страница)
        $hasPagination = $currentPage > 1;
        
        if ($category && !$request->get('query')) {
            // Laravel автоматически декодирует URL параметры, но на всякий случай используем urldecode
            $decodedCategory = urldecode($category);
            $title = 'Статьи по теме: ' . $decodedCategory;
            if ($hasPagination) {
                $title .= '. Страница ' . $currentPage . ' из ' . $lastPage;
            }
            $resource = (object)[
                'title' => $title,
                'description' => 'Статьи о совместной подготовке к беременности: ' . $decodedCategory
            ];
            $forceDynamic = true; // Принудительно используем динамические значения
        } else {
            $title = 'Статьи и советы';
            if ($hasPagination) {
                $title .= '. Страница ' . $currentPage . ' из ' . $lastPage;
                $forceDynamic = true; // При пагинации используем динамические значения
            }
            $resource = (object)[
                'title' => $title,
                'description' => 'Статьи о подготовке к беременности'
            ];
        }
        $pageType = 'Article';

        // Передаем похожие по категориям в шаблон
        $similarByCategory = isset($similarByCategory) ? $similarByCategory : collect();

        return view('site.articles.index', compact('resources', 'categories', 'resource', 'pageType', 'similarByCategory', 'forceDynamic'));
    }

    public function show($alias): View
    {
        $resource = Article::where('alias', $alias)
            ->where('active', 1)
            ->firstOrFail();

        $other = Article::where('active', 1)
            ->where('id', '!=', $resource->id)
            ->orderBy('created_at', 'DESC')
            ->take(3)
            ->get();

        $events = Event::where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->take(2)
            ->get();

        $pageType = '';

        return view('site.articles.show', compact('resource', 'other', 'events', 'pageType'));
    }

    public function subscribe(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function like($alias): JsonResponse
    {
        $article = Article::where('alias', $alias)
            ->where('active', 1)
            ->firstOrFail();

        $article->increment('likes_count');

        return response()->json([
            'success' => true,
            'likes_count' => $article->fresh()->likes_count
        ]);
    }
}
