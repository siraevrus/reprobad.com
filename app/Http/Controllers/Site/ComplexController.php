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
        $resource = Complex::where('alias', $alias)->where('active', 1)->firstOrFail();
        $articles = Article::where('active', 1)->take(5)->get();
        $resources = Complex::where('active', 1)->get();

        $pageType = 'Complex';

        return view('site.complex.show', compact('resource', 'articles', 'resources', 'pageType'));
    }
}
