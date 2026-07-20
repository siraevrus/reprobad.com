<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Text;
use Illuminate\View\View;

class TextController extends Controller
{
    public function index(): View
    {
        $resources = Text::active()->orderBy('title')->get();
        $resource = (object) [
            'title' => 'Информация',
            'description' => 'Информационные страницы',
            'seo_title' => 'Информация — Репробад',
            'seo_description' => 'Информационные страницы сайта Репробад.',
        ];

        return view('site.text.index', compact('resources', 'resource'));
    }

    public function show($alias): View
    {
        $resource = Text::active()->where('alias', $alias)->firstOrFail();

        return view('site.text', compact('resource'));
    }
}
