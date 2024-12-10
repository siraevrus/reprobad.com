<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Complex;
use Illuminate\View\View;

class ComplexController extends Controller
{
    public function index(): View
    {
        $resources = Complex::active()->paginate(12);
        return view('site.complex.index', [
            'resources' => $resources,
            'bodyClass' => 'products-page',
            'isHome' => 1
        ]);
    }

    public function show($alias): View
    {
        $articles = Article::active()->where('active', 1)->take(5)->get();
        $resource = Complex::active()->with('products')->where('alias', $alias)->firstOrFail();
        $resources = Complex::active()->get();
        return view('site.complex.show', compact('resource', 'articles', 'resources'));
    }
}
