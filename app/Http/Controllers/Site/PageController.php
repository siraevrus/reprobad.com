<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Complex;
use App\Models\Page;
use App\Support\DataUriImageMaterializer;
use Illuminate\View\View;

class PageController extends Controller
{
    public function company(): View
    {
        $resource = Page::active()->find(1);
        $pageType = 'Company';
        return view('site.company', compact('resource', 'pageType'));
    }

    public function privacy(): View
    {
        $resource = Page::active()->find(2);
        return view('site.text', compact('resource'));
    }

    public function about(DataUriImageMaterializer $materializer): View
    {
        $resource = Page::active()->find(3);
        if (! $resource) {
            abort(404);
        }
        $content = $resource->content ?? [];
        [$content, $changed] = $materializer->replaceDataUrisInTree($content, 'pages');
        if ($changed) {
            $resource->content = $content;
            $resource->save();
        }
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
