<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class MenuController extends Controller
{
    public array $rules = [
        'day' => 'required|integer|min:1|max:7|unique:menus,day',
        'title' => 'required|string',
        'alias' => 'required|unique:menus,alias',
        'description' => 'string|nullable',
        'seo_title' => 'string|nullable|max:60',
        'seo_description' => 'string|nullable|max:160',
        'menu_data' => 'nullable|array',
        'active' => 'boolean|required',
    ];

    public function index(): View|JsonResponse
    {
        $resources = Menu::query()->sorted()->paginate(env('PAGINATION_LIMIT', 20));

        if(request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.menus.index', compact('resources'));
    }

    public function show(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');
        $resource = Menu::query()->findOrFail($id);
        return response()->json($resource);
    }

    public function store(Request $request) : JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        // Обрабатываем menu_data до валидации
        $data = $request->all();
        if (isset($data['menu_data'])) {
            // Если это строка (JSON), декодируем
            if (is_string($data['menu_data']) && !empty($data['menu_data'])) {
                $decoded = json_decode($data['menu_data'], true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $data['menu_data'] = $decoded;
                } else {
                    $data['menu_data'] = null;
                }
            }
            // Если это объект (stdClass или любой другой объект), преобразуем в массив
            if (is_object($data['menu_data'])) {
                $data['menu_data'] = json_decode(json_encode($data['menu_data']), true);
            }
            // Убеждаемся что это массив или null
            if (!is_array($data['menu_data']) && $data['menu_data'] !== null) {
                $data['menu_data'] = null;
            }
        } else {
            // Если menu_data не передан, устанавливаем null
            $data['menu_data'] = null;
        }

        $validator = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        
        // menu_data уже обработан до валидации, просто убеждаемся что это массив
        if (isset($validated['menu_data']) && !is_array($validated['menu_data'])) {
            return response()->json([
                'success' => false,
                'errors' => ['menu_data' => ['menu_data должен быть массивом']]
            ], 422);
        }
        
        $resource = Menu::query()->create($validated);
        
        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        // Обрабатываем menu_data до валидации
        $data = $request->all();
        if (isset($data['menu_data'])) {
            // Если это строка (JSON), декодируем
            if (is_string($data['menu_data']) && !empty($data['menu_data'])) {
                $decoded = json_decode($data['menu_data'], true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $data['menu_data'] = $decoded;
                } else {
                    $data['menu_data'] = null;
                }
            }
            // Если это объект (stdClass или любой другой объект), преобразуем в массив
            if (is_object($data['menu_data'])) {
                $data['menu_data'] = json_decode(json_encode($data['menu_data']), true);
            }
            // Убеждаемся что это массив или null
            if (!is_array($data['menu_data']) && $data['menu_data'] !== null) {
                $data['menu_data'] = null;
            }
        } else {
            // Если menu_data не передан, устанавливаем null
            $data['menu_data'] = null;
        }

        $validator = Validator::make($data, array_merge($this->rules, [
            'day' => 'required|integer|min:1|max:7|unique:menus,day,' . $id,
            'alias' => 'required|unique:menus,alias,' . $id,
        ]));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        
        // menu_data уже обработан до валидации, просто убеждаемся что это массив
        if (isset($validated['menu_data']) && !is_array($validated['menu_data'])) {
            return response()->json([
                'success' => false,
                'errors' => ['menu_data' => ['menu_data должен быть массивом']]
            ], 422);
        }
        
        $resource = Menu::query()->findOrFail($id);
        $resource->fill($validated);
        $resource->save();

        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $resource = Menu::query()->findOrFail($id);
        $resource->delete();
        return back();
    }

    public function create(): View
    {
        return view('admin.menus.create');
    }

    public function edit($id): View
    {
        return view('admin.menus.create', compact('id'));
    }

    public function switch($id): RedirectResponse
    {
        $resource = Menu::query()->findOrFail($id);
        $resource->active = $resource->active === 0;
        $resource->save();
        session()->flash('message', 'Статус публикации обновлен');
        return back();
    }
}
