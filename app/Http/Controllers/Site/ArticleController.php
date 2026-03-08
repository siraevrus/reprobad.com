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
        if ($request->get('query')) {
            $query = strtolower($request->get('query'));
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
            $articlesByCategory = Article::where('active', 1)
                ->whereNotNull('category')
                ->where('category', 'like', '%' . $query . '%')
                ->get()
                ->map(function($item) {
                    $item->type = 'article';
                    $item->route_name = 'site.articles.show';
                    return $item;
                });
            $advisesByCategory = Advise::where('active', 1)
                ->whereNotNull('category')
                ->where('category', 'like', '%' . $query . '%')
                ->get()
                ->map(function($item) {
                    $item->type = 'advise';
                    $item->route_name = 'site.advises.show';
                    return $item;
                });
            $similarByCategory = $articlesByCategory->concat($advisesByCategory)
                ->sortByDesc('created_at')
                ->take(2)
                ->values();
            $allResources = $articles->concat($advises)
                ->concat($articlesByCategory)
                ->concat($advisesByCategory)
                ->unique(function($item) {
                    return $item->type . '_' . $item->alias;
                })
                ->sortByDesc('created_at')
                ->values();
            $page = $request->get('page', 1);
            $perPage = 11;
            $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
            $items = $allResources->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $resources = new \Illuminate\Pagination\LengthAwarePaginator($items, $allResources->count(), $perPage, $currentPage, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        } else {
            $resources = Article::where('active', 1);
            if ($request->get('category')) {
                $resources = $resources->where('category', $request->get('category'));
            }

            $resources = $resources->orderBy('created_at', 'desc')->paginate(11)->withQueryString();
        }
        $categories = Article::where('active', 1)
            ->whereNotNull('category')
            ->selectRaw('category as name, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('name')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'count' => $item->count
                ];
            })
            ->values();
        $category = $request->get('category');
        $searchQuery = $request->get('query');
        $forceDynamic = false;
        $currentPage = $resources->currentPage();
        $lastPage = $resources->lastPage();
        $hasPagination = $currentPage > 1;
        if ($searchQuery) {
            $decodedQuery = urldecode($searchQuery);
            $totalCount = isset($allResources) ? $allResources->count() : $resources->total();
            $title = 'Статьи и советы: поиск "' . $decodedQuery . '"';
            $description = 'Статьи о совместной подготовке к успешному зачатию, беременности и улучшению здоровья - найдено "' . $totalCount . '" материалов';
            $resource = (object)[
                'title' => $title,
                'description' => $description
            ];
            $forceDynamic = true;
        } elseif ($category && !$searchQuery) {
            $decodedCategory = urldecode($category);
            $title = 'Статьи по теме: ' . $decodedCategory;
            if ($hasPagination) {
                $title .= '. Страница ' . $currentPage . ' из ' . $lastPage;
            }
            $resource = (object)[
                'title' => $title,
                'description' => 'Статьи о совместной подготовке к беременности: ' . $decodedCategory
            ];
            $forceDynamic = true;
        } else {
            $title = 'Статьи и советы';
            if ($lastPage > 1) {
                $title .= '. Страница ' . $currentPage . ' из ' . $lastPage;
                $forceDynamic = true;
            }
            $resource = (object)[
                'title' => $title,
                'description' => 'Статьи о подготовке к беременности'
            ];
        }
        $pageType = 'Article';
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
        $resource->seo_title = strip_tags($resource->title) . ': Статьи';

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
