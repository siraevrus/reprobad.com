<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Event;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $resources = Faq::where('active', 1)->get();
        $events = Event::where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->take(2)
            ->get();
        $pageType = 'Faq';
        $forceDynamic = true;
        $resource = (object)[
            'title' => 'Вопрос-ответ',
            'description' => 'Вопрос-ответ',
            'seo_title' => 'Вопросы и ответы — Репробад',
            'seo_description' => 'Ответы на частые вопросы о системе РЕПРО и продуктах: применение, рекомендации и важные нюансы.'
        ];

        return view('site.faq', compact('resource', 'pageType', 'forceDynamic', 'resources', 'events'));
    }
}
