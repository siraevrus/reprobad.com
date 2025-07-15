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

        $resources = $resources->orderBy('sort', 'desc')->paginate(7);

        $monthsOrder = [
            'январь'   => 1,
            'февраль'  => 2,
            'март'     => 3,
            'апрель'   => 4,
            'май'      => 5,
            'июнь'     => 6,
            'июль'     => 7,
            'август'   => 8,
            'сентябрь' => 9,
            'октябрь'  => 10,
            'ноябрь'   => 11,
            'декабрь'  => 12,
        ];

        $allEvents = Event::where('active', 1)->get();

        $categories = Event::where('active', 1)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->map(function ($category) use ($allEvents) {
                return [
                    'name'  => $category,
                    'count' => $allEvents->where('category', $category)->count()
                ];
            })
            ->sortBy(function ($item) use ($monthsOrder) {
                $parts = explode(' ', mb_strtolower($item['name']));
                $month = $parts[0] ?? '';
                $year = (int) ($parts[1] ?? 0);

                $monthNumber = $monthsOrder[$month] ?? 0;

                // Сортируем по году, потом по месяцу
                return $year * 100 + $monthNumber;
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
        $other = Event::where('active', 1)
            ->where('id', '!=', $resource->id)
            ->orderBy('created_at', 'DESC')
            ->take(2)
            ->get();

        $pageType = 'Event';

        return view('site.events.show', compact('resource', 'other', 'pageType'));
    }
}
