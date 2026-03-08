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
        $resources = Event::where('active', 1)
            ->select('id', 'title', 'description', 'dates', 'address', 'alias', 'sort', 'created_at', 'category');

        if ($request->get('category')) {
            $resources = $resources->where('category', $request->get('category'));
        }

        if ($request->get('query')) {
            $query = strtolower($request->get('query'));
            $resources = $resources->where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%');
            });
        }

        $resources = $resources->orderBy('sort', 'desc')->paginate(7)->withQueryString();

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

        $categories = Event::where('active', 1)
            ->selectRaw('category, COUNT(*) as count')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderBy('category', 'desc')
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

        $category = $request->get('category');
        $forceDynamic = false;
        $currentPage = $resources->currentPage();
        $lastPage = $resources->lastPage();
        $hasPagination = $currentPage > 1;
        
        if ($category) {
            $decodedCategory = urldecode($category);
            $title = 'События и мероприятия: ' . $decodedCategory;
            if ($hasPagination) {
                $title .= '. Страница ' . $currentPage . ' из ' . $lastPage;
            }
            $resource = (object)[
                'title' => $title,
                'description' => 'События и мероприятия посвященные теме репродуктологии: ' . $decodedCategory
            ];
            $forceDynamic = true;
        } else {
            $title = 'События и мероприятия';
            if ($hasPagination) {
                $title .= '. Страница ' . $currentPage . ' из ' . $lastPage;
                $forceDynamic = true;
            }
            $resource = (object)[
                'title' => $title,
                'description' => 'События о подготовке к беременности'
            ];
        }
        $pageType = 'Event';

        return view('site.events.index', compact('resources', 'categories', 'resource', 'pageType', 'forceDynamic'));
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
        $resource->seo_title = strip_tags($resource->title) . ': События и мероприятия';

        return view('site.events.show', compact('resource', 'other', 'pageType'));
    }
}
