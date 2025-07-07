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
        
        // SEO данные для списка комплексов
        $pageType = 'Complex';
        $pageId = 0; // 0 означает список комплексов
        
        return view('site.complex.index', [
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
        $resource = Complex::active()->with('products')->where('alias', $alias)->firstOrFail();
        $resources = Complex::active()->get();
        
        // SEO данные для конкретного комплекса
        $pageType = 'Complex';
        $pageId = $resource->id;
        
        return view('site.complex.show', compact('resource', 'articles', 'resources', 'pageType', 'pageId'));
    }
}
