<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Advise;
use App\Models\Article;
use App\Models\Complex;
use App\Models\Event;
use App\Models\Product;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index(): View
    {
        $resource = [
            'home' => 1,
            'title' => 'Главная'
        ];
        $resources = Article::active()->take(5)->get();
        $complexes = Complex::active()->get();
        $events = Event::active()->take(2)->get();
        return view('site.index', compact('resource', 'complexes', 'resources', 'events'));
    }
}
