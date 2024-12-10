<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Complex;
use App\Models\Page;
use App\Models\Product;
use Illuminate\View\View;

class PageController extends Controller
{
    public function company(): View
    {
        $resource = Page::query()
            ->where('alias', 'o-kompanii-r-farm')
            ->firstOrFail();
        return view('site.company', compact('resource'));
    }

    public function privacy(): View
    {
        $resource = Page::query()
            ->where('alias', 'privacy')
            ->firstOrFail();
        return view('site.text', compact('resource'));
    }

    public function about(): View
    {
        $resource = Page::query()
            ->where('alias', 'about')
            ->firstOrFail();
        $complexes = Complex::query()->get();
        return view('site.about', compact('resource', 'complexes'));
    }

    public function contacts(): View
    {
        $resource = [
            'title' => 'Контакты',
            'description' => 'Контакты'
        ];
        return view('site.contacts', compact('resource'));
    }
}
