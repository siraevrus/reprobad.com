<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $resources = Faq::where('active', 1)->orderBy('sort', 'asc')->get();
        $pageType = 'faq';
        $resource = (object)[
            'title' => 'Вопросы - ответы',
            'description' => 'Вопросы - ответы'
        ];

        return view('site.faq.index', compact('resource', 'pageType'));
    }
}
