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
        $resources = Product::active()->paginate(12);
        
        // SEO данные для списка продуктов
        $pageType = 'Product';
        $pageId = 0; // 0 означает список продуктов
        
        return view('site.products.index', [
            'resources' => $resources,
            'bodyClass' => 'products-page',
            'isHome' => 1,
            'pageType' => $pageType,
            'pageId' => $pageId
        ]);
    }

    public function show($alias): View
    {
        $articles = Article::active()->where('active', 1)->take(5)->get();
        $resource = Product::active()->where('alias', $alias)->firstOrFail();
        $complexes = Complex::active()->get();
        
        // SEO данные для конкретного продукта
        $pageType = 'Product';
        $pageId = $resource->id;
        
        return view('site.products.show', compact('resource', 'articles', 'complexes', 'pageType', 'pageId'));
    }
}
