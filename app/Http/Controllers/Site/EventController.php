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
        $resources = Event::where('active', 1)->orderBy('sort', 'asc')->get();
        $categories = Event::where('active', 1)->distinct()->pluck('category')->filter();
        
        $resource = null;
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
