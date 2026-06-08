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
        $resources = Complex::where('active', 1)->orderBy('sort', 'asc')->get();

        $resource = null;
        $pageType = 'Complex';

        return view('site.complex.index', compact('resources', 'resource', 'pageType'));
    }

    public function show($alias): View
    {
        // Используем eager loading для products, чтобы избежать N+1 проблемы
        $resource = Complex::where('alias', $alias)
            ->where('active', 1)
            ->with(['products' => function($query) {
                $query->where('active', 1)->orderBy('sort', 'ASC');
            }])
            ->firstOrFail();
        
        $articles = Article::active()->orderBy('created_at', 'desc')->take(5)->get();
        $resources = Complex::active()->get();

        $pageType = 'Complex';
        $forceDynamic = true;

        // Используем SEO-поля из БД; если они пусты — формируем автоматически
        $titlePlain = strip_tags($resource->title);
        if (empty(trim($resource->seo_title ?? ''))) {
            $resource->seo_title = $titlePlain . ' | Система РЕПРО';
        }
        if (empty(trim($resource->seo_description ?? ''))) {
            $resource->seo_description = $resource->subtitle
                ?: strip_tags($resource->description ?? '');
        }

        return view('site.complex.show', compact('resource', 'articles', 'resources', 'pageType', 'forceDynamic'));
    }
}
