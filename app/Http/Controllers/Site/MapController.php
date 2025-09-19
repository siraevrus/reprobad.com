<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Point;
use Illuminate\View\View;

class MapController extends Controller
{
    public function index(): View
    {
        $resources = Point::active()->get()->toJson();
        
        // Получаем уникальные города для dropdown
        $cities = Point::active()
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->pluck('city')
            ->sort()
            ->values();
            
        return view('site.map', compact('resources', 'cities'));
    }
}
