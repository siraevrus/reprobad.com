<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advise;
use App\Models\Article;
use App\Models\Event;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Product;
use App\Services\CityStatsService;
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
        $menus = Menu::query()->count();
        
        // Получаем статистику выбора городов
        $cityStatsService = app(CityStatsService::class);
        $cityStats = $cityStatsService->getStatsSorted();
        $totalCitySelections = $cityStatsService->getTotalSelections();
        
        return view('admin.index', compact('articles', 'pages', 'advises', 'products', 'events', 'menus', 'cityStats', 'totalCitySelections'));
    }
}
