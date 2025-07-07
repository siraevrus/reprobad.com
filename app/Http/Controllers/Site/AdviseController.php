<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Advise;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AdviseController extends Controller
{
    public function index(Request $request): View
    {
        $resources = Advise::active();
        $categories = Advise::active()->distinct()->pluck('category');

        if($request->get('category')) {
            $resources = $resources->where('category', $request->get('category'));
        }

        if($request->get('query')) {
            $query = $request->get('query');
            $resources = $resources
                ->where('title', 'like', '%' . $query . '%')
                ->where('description', 'like', '%' . $query . '%')
                ->orWhere('content', 'like', '%' . $query . '%');
        }

        $resources = $resources->paginate(7);

        $all = Advise::active()->get();
        $categories = $categories
            ->filter(fn($item) => !empty($item)) // убираем пустые
            ->map(function ($item) use ($all) {
                return [
                    'name' => $item,
                    'count' => $all->where('category', $item)->count()
                ];
            })
            ->values();

        $resource = [
            'title' => 'Полезные советы',
            'description' => 'Полезные советы по подготовке к беременности'
        ];

        // SEO данные для списка советов
        $pageType = 'Advise';
        $pageId = 0; // 0 означает список советов

        return view('site.advises.index', compact('resources', 'categories', 'resource', 'pageType', 'pageId'));
    }

    public function show($alias): View
    {
        $resource = Advise::active()->where('alias', $alias)->firstOrFail();
        $events = Event::active()->take(6)->get();
        
        // SEO данные для конкретного совета
        $pageType = 'Advise';
        $pageId = $resource->id;
        
        return view('site.advises.show', compact('resource', 'events', 'pageType', 'pageId'));
    }

    public function subscribe(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return response()->json(['success' => true]);
    }
}
