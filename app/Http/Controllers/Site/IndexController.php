<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Advise;
use App\Models\Article;
use App\Models\Complex;
use App\Models\Event;
use App\Models\Product;
use App\Models\Question;
use App\Models\Step;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index(): View
    {
        $resource = (object)[
            'home' => 1,
            'title' => 'Главная'
        ];
        
        // Оптимизация: используем select только нужных полей для уменьшения памяти
        $resources = Article::active()
            ->select('id', 'title', 'description', 'alias', 'image', 'icon', 'created_at', 'time', 'category')
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
        
        $complexes = Complex::active()
            ->select('id', 'title', 'alias', 'subtitle', 'image_left', 'image_right', 'color', 'sort')
            ->get();
        
        $events = Event::active()
            ->select('id', 'title', 'description', 'dates', 'address', 'alias', 'created_at')
            ->orderBy('sort', 'desc')
            ->take(2)
            ->get();

        // Оптимизация: используем один запрос с union вместо трех отдельных
        $d1 = DB::table('articles')
            ->select('id', 'title', 'home', DB::raw("'article' as type"))
            ->where('home', 1);

        $d2 = DB::table('events')
            ->select('id', 'title', 'home', DB::raw("'event' as type"))
            ->where('home', 1);

        $d3 = DB::table('advises')
            ->select('id', 'title', 'home', DB::raw("'advise' as type"))
            ->where('home', 1);

        $favorites = $d1
            ->union($d2)
            ->union($d3)
            ->orderBy('id', 'desc')
            ->get();

        $pageType = 'Home';

        // Оптимизация: загружаем только нужные поля для questions и steps
        $questions = Question::active()
            ->select('id', 'title', 'text', 'icon')
            ->get();
        
        $steps = Step::active()
            ->select('id', 'title')
            ->get();

        return view('site.index', compact('resource', 'complexes', 'resources', 'pageType', 'events', 'favorites', 'questions', 'steps'));
    }
}
