<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $resources = Event::query();
        $categories = Event::query()->distinct()->pluck('category');

        if(request()->get('category')) {
            $resources = $resources->where('category', request()->get('category'));
        }

        if(request()->get('query')) {
            $resources = $resources
                ->where('title', 'like', '%' . request()->get('query') . '%')
                ->where('description', 'like', '%' . request()->get('query') . '%')
                ->orWhere('content', 'like', '%' . request()->get('query') . '%');
        }

        $resources = $resources->paginate(7);

        $all = Event::query()->get();
        $categories = $categories->map(function ($item) use ($all) {
            return [
                'name' => $item,
                'count' => $all->where('category', $item)->count()
            ];
        });

        $resource = [
            'title' => 'События',
            'description' => 'События'
        ];

        return view('site.events.index', compact('resources', 'categories', 'resource'));
    }

    public function show($alias): View
    {
        $resource = Event::query()->where('alias', $alias)->firstOrFail();
        $other = Event::query()
            ->where('category', $resource->category)
            ->where('id', '!=', $resource->id)
            ->take(6)
            ->get();
        return view('site.events.show', compact('resource', 'other'));
    }


}
