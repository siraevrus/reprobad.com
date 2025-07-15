<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $resources = Article::where('active', 1);

        // Фильтрация по категории
        if ($request->get('category')) {
            $resources = $resources->where('category', $request->get('category'));
        }

        // Поиск
        if ($request->get('query')) {
            $query = strtolower($request->get('query'));
            $resources = $resources->where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('content', 'like', '%' . $query . '%');
            });
        }

        $resources = $resources->orderBy('created_at', 'desc')->paginate(7);

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

        $resource = (object)[
            'title' => 'Статьи',
            'description' => 'Статьи о подготовке к беременности'
        ];
        $pageType = 'Article';

        return view('site.articles.index', compact('resources', 'categories', 'resource', 'pageType'));
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

        $pageType = 'Article';

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
}
