<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Product;

class PageController extends Controller
{
    public function company()
    {
        $resource = Page::query()
            ->where('alias', 'o-kompanii-r-farm')
            ->firstOrFail();
        return view('site.company', compact('resource'));
    }

    public function privacy()
    {
        $resource = Page::query()
            ->where('alias', 'privacy')
            ->firstOrFail();
        return view('site.text', compact('resource'));
    }

    public function about()
    {
        $resource = Page::query()
            ->where('alias', 'about')
            ->firstOrFail();
        $products = Product::query()->get();
        return view('site.about', compact('resource', 'products'));
    }

    public function contacts()
    {
        $resource = [
            'title' => 'Контакты',
            'description' => 'Контакты'
        ];
        return view('site.contacts', compact('resource'));
    }
}
