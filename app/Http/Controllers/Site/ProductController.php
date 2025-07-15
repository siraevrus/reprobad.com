<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Complex;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $resources = Product::where('active', 1)->orderBy('sort', 'asc')->get();

        $resource = null;
        $pageType = 'Product';

        return view('site.products.index', compact('resources', 'resource', 'pageType'));
    }

    public function show($alias): View
    {
        $resource = Product::where('alias', $alias)->where('active', 1)->firstOrFail();
        $articles = Article::where('active', 1)->take(5)->get();
        $complexes = Complex::where('active', 1)->take(3)->get();

        $pageType = 'Product';

        return view('site.products.show', compact('resource', 'articles', 'complexes', 'pageType'));
    }
}
