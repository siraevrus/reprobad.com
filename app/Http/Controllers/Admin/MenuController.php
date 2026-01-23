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
        'menu_data' => 'string|nullable',
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

        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        
        // Декодируем и валидируем JSON если он пришел как строка
        if (isset($validated['menu_data']) && is_string($validated['menu_data']) && !empty($validated['menu_data'])) {
            $decoded = json_decode($validated['menu_data'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'errors' => ['menu_data' => ['Невалидный JSON: ' . json_last_error_msg()]]
                ], 422);
            }
            $validated['menu_data'] = $decoded;
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

        $validator = Validator::make($request->all(), array_merge($this->rules, [
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
        
        // Декодируем и валидируем JSON если он пришел как строка
        if (isset($validated['menu_data']) && is_string($validated['menu_data']) && !empty($validated['menu_data'])) {
            $decoded = json_decode($validated['menu_data'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'errors' => ['menu_data' => ['Невалидный JSON: ' . json_last_error_msg()]]
                ], 422);
            }
            $validated['menu_data'] = $decoded;
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
