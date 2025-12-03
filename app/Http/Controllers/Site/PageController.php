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
        $resource = Page::active()->find(1);
        return view('site.company', compact('resource'));
    }

    public function privacy(): View
    {
        $resource = Page::active()->find(2);
        return view('site.text', compact('resource'));
    }

    public function about(): View
    {
        $resource = Page::active()->find(3);
        $complexes = Complex::sorted()->get();
        return view('site.about', compact('resource', 'complexes'));
    }

    public function contacts(): View
    {
        $resource = (object)[
            'title' => 'Контакты',
            'description' => 'Контакты',
        ];
        $pageType = 'Contacts';
        return view('site.contacts', compact('resource', 'pageType'));
    }
}
