<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $resources = Article::query()->paginate(20);
        return view('site.articles.index', compact('resources'));
    }

    public function show($alias): View
    {
        $resource = Article::query()->where('alias', $alias)->firstOrFail();
        return view('site.articles.show', compact('resource'));
    }
}
