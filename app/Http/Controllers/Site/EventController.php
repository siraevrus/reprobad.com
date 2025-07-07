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
        $resources = Event::active();
        $categories = Event::active()->distinct()->pluck('category');

        if($request->get('category')) {
            $resources = $resources->where('category', $request->get('category'));
        }

        if($request->get('query')) {
            $resources = $resources
                ->where('title', 'like', '%' . $request->get('query') . '%')
                ->where('description', 'like', '%' . $request->get('query') . '%')
                ->orWhere('content', 'like', '%' . $request->get('query') . '%');
        }

        $resources = $resources->paginate(7);

        $all = Event::active()->get();
        $categories = $categories->map(function ($item) use ($all) {
            return [
                'name' => $item,
                'count' => $all->where('category', $item)->count()
            ];
        });

        $resource = [
            'title' => 'События',
            'description' => 'События о подготовке к беременности'
        ];

        // SEO данные для списка событий
        $pageType = 'Event';
        $pageId = 0; // 0 означает список событий

        return view('site.events.index', compact('resources', 'categories', 'resource', 'pageType', 'pageId'));
    }

    public function show($alias): View
    {
        $resource = Event::active()->where('alias', $alias)->firstOrFail();
        $other = Event::active()
            ->where('category', $resource->category)
            ->where('id', '!=', $resource->id)
            ->take(6)
            ->get();
            
        // SEO данные для конкретного события
        $pageType = 'Event';
        $pageId = $resource->id;
        
        return view('site.events.show', compact('resource', 'other', 'pageType', 'pageId'));
    }
}
