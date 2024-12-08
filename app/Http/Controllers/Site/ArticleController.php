<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $resources = Article::query();
        $categories = Article::query()->distinct()->pluck('category');

        if(request()->get('category')) {
            $resources = $resources->where('category', request()->get('category'));
        }

        if(request()->get('query')) {
            $resources = $resources
                ->where('title', 'like', '%' . request()->get('query') . '%')
                ->where('description', 'like', '%' . request()->get('query') . '%')
                ->orWhere('content', 'like', '%' . request()->get('query') . '%');
        }

        $resources = $resources->paginate(7);

        $categories = $categories->map(function ($item) use ($resources) {
            return [
                'name' => $item,
                'count' => $resources->where('category', $item)->count()
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
        $resource = Article::query()->where('alias', $alias)->firstOrFail();
        $other = Article::query()
            ->where('category', $resource->category)
            ->where('id', '!=', $resource->id)
            ->take(6)
            ->get();
        return view('site.articles.show', compact('resource', 'other'));
    }

    public function subscribe(Request $request)
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
    }
}
