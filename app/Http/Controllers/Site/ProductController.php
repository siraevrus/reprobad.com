<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $resources = Product::query()->paginate(12);
        return view('site.products.index', [
            'resources' => $resources,
            'bodyClass' => 'products-page',
            'isHome' => 1
        ]);
    }

    public function show($alias)
    {
        $articles = Article::query()->where('active', 1)->take(5)->get();
        $resource = Product::query()->where('alias', $alias)->firstOrFail();
        $products = Product::query()->get();
        return view('site.products.show', compact('resource', 'articles', 'products'));
    }
}
