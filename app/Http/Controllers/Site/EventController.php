<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $resources = Event::where('active', 1);
        
        // Фильтрация по категории
        if ($request->get('category')) {
            $resources = $resources->where('category', $request->get('category'));
        }
        
        // Поиск
        if ($request->get('query')) {
            $query = strtolower($request->get('query'));
            $resources = $resources->where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('content', 'like', '%' . $query . '%');
            });
        }
        
        $resources = $resources->orderBy('sort', 'asc')->paginate(7);
        
        // Получаем категории с подсчетом количества событий
        $allEvents = Event::where('active', 1)->get();
        $categories = Event::where('active', 1)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->map(function ($category) use ($allEvents) {
                return [
                    'name' => $category,
                    'count' => $allEvents->where('category', $category)->count()
                ];
            })
            ->values();
        
        $resource = [
            'title' => 'События',
            'description' => 'События о подготовке к беременности'
        ];
        $pageType = 'Event';
        
        return view('site.events.index', compact('resources', 'categories', 'resource', 'pageType'));
    }

    public function show($alias): View
    {
        $resource = Event::where('alias', $alias)->where('active', 1)->firstOrFail();
        $other = Event::where('active', 1)->where('id', '!=', $resource->id)->take(3)->get();
        
        $pageType = 'Event';
        
        return view('site.events.show', compact('resource', 'other', 'pageType'));
    }
}
