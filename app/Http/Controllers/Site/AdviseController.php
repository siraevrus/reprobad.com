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
        $resources = Advise::where('active', 1);

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

        $resources = $resources->orderBy('created_at', 'desc')->paginate(11);

        // Получаем категории с подсчетом количества советов
        $allAdvises = Advise::where('active', 1)->get();
        $categories = Advise::where('active', 1)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->map(function ($category) use ($allAdvises) {
                return [
                    'name' => $category,
                    'count' => $allAdvises->where('category', $category)->count()
                ];
            })
            ->values();

        $resource = (object)[
            'title' => 'Полезные советы',
            'description' => 'Полезные советы по подготовке к беременности'
        ];
        $pageType = 'Advise';

        return view('site.advises.index', compact('resources', 'categories', 'resource', 'pageType'));
    }

    public function show($alias): View
    {
        $resource = Advise::where('alias', $alias)->where('active', 1)->firstOrFail();
        $events = Event::where('active', 1)->take(2)->get();

        $pageType = 'Advise';

        return view('site.advises.show', compact('resource', 'events', 'pageType'));
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
