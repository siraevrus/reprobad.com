<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Advise;
use App\Models\Article;
use App\Models\Complex;
use App\Models\Event;
use App\Models\Product;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
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

        $questions = Question::active()->get();

        return view('site.index', compact('resource', 'complexes', 'resources', 'events', 'favorites', 'questions'));
    }
}
