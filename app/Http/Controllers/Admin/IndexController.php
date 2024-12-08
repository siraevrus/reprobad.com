<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advise;
use App\Models\Article;
use App\Models\Event;
use App\Models\Page;
use App\Models\Product;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()->count();
        $pages = Page::query()->count();
        $advises = Advise::query()->count();
        $products = Product::query()->count();
        $events = Event::query()->count();
        return view('admin.index', compact('articles', 'pages', 'advises', 'products', 'events'));
    }
}
