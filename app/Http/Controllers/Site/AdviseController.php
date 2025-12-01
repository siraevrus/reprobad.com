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

class AdviseController extends Controller
{
    public function index(Request $request): View
    {
        // Если есть поисковый запрос, ищем в обоих разделах
        if ($request->get('query')) {
            $query = strtolower($request->get('query'));
            
            // Поиск в статьях
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
            
            // Поиск в советах
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
            
            // Объединяем результаты
            $allResources = $articles->concat($advises)
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
            // Обычный режим - только советы
            $resources = Advise::where('active', 1);

            // Фильтрация по категории
            if ($request->get('category')) {
                $resources = $resources->where('category', $request->get('category'));
            }

            $resources = $resources->orderBy('created_at', 'desc')->paginate(11);
        }

        // Получаем категории с подсчетом количества советов
        $allAdvises = Advise::where('active', 1)->get();
        $categories = Advise::where('active', 1)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->map(function ($category) use ($allAdvises) {
                return [
                    'name' => $category,
                    'count' => $allAdvises->where('category', $category)->count()
                ];
            })
            ->values();

        $resource = (object)[
            'title' => 'Полезные советы',
            'description' => 'Полезные советы по подготовке к беременности'
        ];
        $pageType = 'Advise';

        return view('site.advises.index', compact('resources', 'categories', 'resource', 'pageType'));
    }

    public function show($alias): View
    {
        $resource = Advise::where('alias', $alias)->where('active', 1)->firstOrFail();
        $events = Event::where('active', 1)->take(2)->get();

        $pageType = '';

        return view('site.advises.show', compact('resource', 'events', 'pageType'));
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

        return response()->json(['success' => true]);
    }
}
