<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Complex;

class ComplexController extends Controller
{
    public function index()
    {
        $resources = Complex::query()->paginate(12);
        return view('site.complex.index', [
            'resources' => $resources,
            'bodyClass' => 'products-page',
            'isHome' => 1
        ]);
    }

    public function show($alias)
    {
        $articles = Article::query()->where('active', 1)->take(5)->get();
        $resource = Complex::query()->with('products')->where('alias', $alias)->firstOrFail();
        $resources = Complex::query()->get();
        return view('site.complex.show', compact('resource', 'articles', 'resources'));
    }
}
