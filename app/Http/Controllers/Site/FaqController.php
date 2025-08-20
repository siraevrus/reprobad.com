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
        $events = Event::where('active', 1)->take(2)->get();
        $pageType = 'faq';
        $resource = (object)[
            'title' => 'Вопросы - ответы',
            'description' => 'Вопросы - ответы'
        ];

        return view('site.faq', compact('resource', 'pageType', 'resources', 'events'));
    }
}
