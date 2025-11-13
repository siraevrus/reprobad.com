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
        // Исключаем большие поля (content, images, image, logo) из запроса для оптимизации памяти
        // Поля image и logo содержат base64-данные размером до 9.6 МБ, что вызывает ошибки памяти
        // Эти поля загружаются только на странице детального просмотра (show)
        $resources = Event::where('active', 1)
            ->select('id', 'title', 'description', 'dates', 'address', 'alias', 'sort', 'created_at', 'category');

        // Фильтрация по категории
        if ($request->get('category')) {
            $resources = $resources->where('category', $request->get('category'));
        }

        // Поиск - используем только поля, которые есть в select
        if ($request->get('query')) {
            $query = strtolower($request->get('query'));
            $resources = $resources->where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%');
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

        // Оптимизация: получаем категории и их количество через группировку в БД, без загрузки всех событий
        // Используем только поле category для минимизации данных
        $categories = Event::where('active', 1)
            ->selectRaw('category, COUNT(*) as count')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderBy('category', 'desc') // Предварительная сортировка в БД
            ->get()
            ->map(function ($item) {
                return [
                    'name'  => $item->category,
                    'count' => (int)$item->count
                ];
            })
            ->sortByDesc(function ($item) use ($monthsOrder) {
                $parts = explode(' ', mb_strtolower($item['name']));
                $month = $parts[0] ?? '';
                $year = (int) ($parts[1] ?? 0);

                $monthNumber = $monthsOrder[$month] ?? 0;

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

        $pageType = '';

        return view('site.events.show', compact('resource', 'other', 'pageType'));
    }
}
