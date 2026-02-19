<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Event;
use App\Services\ImageService;
use App\Services\InputService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ArticleController extends Controller
{

    public array $rules = [
        'title' => 'required|string',
        'content' => 'required|string',
        'alias' => 'required|unique:articles,alias',
        'description' => 'string|nullable',
        'image' => 'string|nullable',
        'icon' => 'string|nullable',
        'category' => 'string|nullable',
        'time' => 'string|nullable',
        'active' => 'boolean|required',
        'seo_description' => 'string|nullable',
    ];

    public function index(): View|JsonResponse
    {
        $resources = Article::query()->paginate(env('PAGINATION_LIMIT', 20));

        if(request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.articles.index', compact('resources'));
    }

    public function show(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');
        $resource = Article::query()->findOrFail($id);
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

        // Исключаем поля с изображениями из validated, чтобы не сохранять base64 в БД
        $imageFields = ['image', 'icon'];
        $dataForSave = array_diff_key($validated, array_flip($imageFields));

        $resource = Article::query()->create($dataForSave);
        
        // Обработка изображений через InputService (конвертирует base64 в файлы)
        try {
            InputService::uploadFile($request->image, $resource, 'image');
            InputService::uploadFile($request->icon, $resource, 'icon');
        } catch (\Exception $e) {
            \Log::error('Error uploading images for new article: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'errors' => ['image' => ['Ошибка при загрузке изображения: ' . $e->getMessage()]]
            ], 500);
        }
        
        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), array_merge($this->rules, [
            'alias' => 'required|unique:articles,alias,' . $id,
        ]));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Исключаем поля с изображениями из validated, чтобы не сохранять base64 в БД
        $imageFields = ['image', 'icon'];
        $dataForSave = array_diff_key($validated, array_flip($imageFields));

        $resource = Article::query()->findOrFail($id);
        $resource->fill($dataForSave);
        $resource->save();

        // Обработка изображений через InputService (конвертирует base64 в файлы)
        try {
            InputService::uploadFile($request->image, $resource, 'image');
            InputService::uploadFile($request->icon, $resource, 'icon');
        } catch (\Exception $e) {
            \Log::error('Error uploading images for article ' . $id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'errors' => ['image' => ['Ошибка при загрузке изображения: ' . $e->getMessage()]]
            ], 500);
        }

        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $resource = Article::query()->findOrFail($id);
        $resource->delete();
        return back();
    }

    public function create(): View
    {
        $files = Storage::disk('public')->files('icons');
        $icons = array_map(fn($file) => Storage::disk('public')->url($file), $files);
        return view('admin.articles.create', compact('icons'));
    }

    public function edit(): View
    {
        $files = Storage::disk('public')->files('icons');
        $icons = array_map(fn($file) => Storage::disk('public')->url($file), $files);
        return view('admin.articles.create', compact('icons'));
    }

    public function switch($id): RedirectResponse
    {
        $resource = Article::query()->findOrFail($id);
        $resource->active = $resource->active === 0;
        $resource->save();
        session()->flash('message', 'Статус публикации обновлен');
        return back();
    }

    public function home($id): RedirectResponse
    {
        $resource = Article::findOrFail($id);
        $resource->home = $resource->home == false;
        $resource->save();
        session()->flash('message', 'Элементы на главной странице обновлены');
        return back();
    }
}
