<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $resources = Article::active();
        $categories = Article::active()->distinct()->pluck('category');

        if($request->get('category')) {
            $resources = $resources->where('category', $request->get('category'));
        }

        if($request->get('query')) {
            $query = strtolower($request->get('query'));
            $resources = $resources
                ->where('title', 'like', '%' . $query . '%')
                ->where('description', 'like', '%' . $query . '%')
                ->orWhere('content', 'like', '%' . $query . '%');
        }

        $resources = $resources->paginate(7);

        $all = Article::active()->get();
        $categories = $categories->map(function ($item) use ($all) {
            return [
                'name' => $item,
                'count' => $all->where('category', $item)->count()
            ];
        });

        $resource = [
            'title' => 'События',
            'description' => 'События'
        ];

        return view('site.articles.index', compact('resources', 'categories', 'resource'));
    }

    public function show($alias): View
    {
        $resource = Article::active()->where('alias', $alias)->firstOrFail();
        $other = Article::active()
            ->where('category', $resource->category)
            ->where('id', '!=', $resource->id)
            ->take(6)
            ->get();
        return view('site.articles.show', compact('resource', 'other'));
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
