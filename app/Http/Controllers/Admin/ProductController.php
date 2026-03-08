<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\InputService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProductController extends Controller
{

    public array $rules = [
        'title' => 'required|max:255',
        'content' => 'string|nullable',
        'alias' => 'required|unique:articles,alias|max:255',
        'description' => 'nullable',
        'image' => 'string|nullable',
        'image_alt' => 'string|nullable',
        'logo' => 'string|nullable',
        'logo_alt' => 'string|nullable',
        'includes' => 'string|nullable',
        'link' => 'string|nullable',
        'text' => 'string|nullable',
        'usage' => 'string|nullable',
        'about' => 'string|nullable',
        'photo' => 'string|nullable',
        'subtitle' => 'string|nullable',
        'image_left' => 'string|nullable',
        'image_right' => 'string|nullable',
        'title_left' => 'string|nullable',
        'color' => 'string|nullable',
        'products' => 'string|nullable',
        'title_right' => 'string|nullable',
        'complex_id' => 'integer|nullable',
        'seo_description' => 'string|nullable|max:255',
        'ai_content' => 'string|nullable',
    ];

    public function index(): View|JsonResponse
    {
        $resources = Product::sorted()->paginate(env('PAGINATION_LIMIT', 20));

        if(request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.products.index', compact('resources'));
    }

    public function show(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');
        $resource = Product::query()->findOrFail($id);
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
        $imageFields = ['image', 'photo', 'logo', 'images', 'video', 'image_left', 'image_right'];
        $dataForSave = array_diff_key($validated, array_flip($imageFields));

        $resource = Product::query()
            ->create($dataForSave);

        // Обработка изображений через InputService (конвертирует base64 в файлы)
        InputService::uploadFile($request->image, $resource, 'image');
        InputService::uploadFile($request->photo, $resource, 'photo');
        InputService::uploadFile($request->logo, $resource, 'logo');
        InputService::uploadGallery($request->images, $resource, 'images');
        InputService::uploadFile($request->video, $resource, 'video');
        InputService::uploadFile($request->image_left, $resource, 'image_left');
        InputService::uploadFile($request->image_right, $resource, 'image_right');

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
        $imageFields = ['image', 'photo', 'logo', 'images', 'video', 'image_left', 'image_right'];
        $dataForSave = array_diff_key($validated, array_flip($imageFields));

        $resource = Product::query()->findOrFail($id);
        $resource->fill($dataForSave);
        $resource->save();

        // Обработка изображений через InputService (конвертирует base64 в файлы)
        InputService::uploadFile($request->image, $resource, 'image');
        InputService::uploadFile($request->photo, $resource, 'photo');
        InputService::uploadFile($request->logo, $resource, 'logo');
        InputService::uploadGallery($request->images, $resource, 'images');
        InputService::uploadFile($request->video, $resource, 'video');
        InputService::uploadFile($request->image_left, $resource, 'image_left');
        InputService::uploadFile($request->image_right, $resource, 'image_right');

        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $resource = Product::query()->findOrFail($id);
        $resource->delete();
        return back();
    }

    public function create(): View
    {
        return view('admin.products.create');
    }

    public function edit(): View
    {
        return view('admin.products.create');
    }

    public function switch($id): RedirectResponse
    {
        $resource = Product::query()->findOrFail($id);
        $resource->active = $resource->active === 0;
        $resource->save();
        session()->flash('message', 'Статус публикации обновлен');
        return back();
    }

    public function up(Request $request, $id): RedirectResponse
    {
        $this->initializeSortValues(); // Проверка и инициализация sort

        $resource = Product::findOrFail($id);
        $resourceAbove = Product::where('sort', '<', $resource->sort)
            ->orderBy('sort', 'desc')
            ->first();

        if ($resourceAbove) {
            $tempOrder = $resource->sort;
            $resource->sort = $resourceAbove->sort;
            $resourceAbove->sort = $tempOrder;
            $resourceAbove->save();
        }
        $resource->save();
        session()->flash('message', 'Порядок элементов обновлен');
        return back();
    }

    public function down(Request $request, $id): RedirectResponse
    {
        $this->initializeSortValues(); // Проверка и инициализация sort

        $resource = Product::findOrFail($id);
        $resourceBelow = Product::where('sort', '>', $resource->sort)
            ->orderBy('sort', 'asc')
            ->first();

        if ($resourceBelow) {
            $tempOrder = $resource->sort;
            $resource->sort = $resourceBelow->sort;
            $resourceBelow->sort = $tempOrder;
            $resourceBelow->save();
        }
        $resource->save();
        session()->flash('message', 'Порядок элементов обновлен');
        return back();
    }

    /**
     * Инициализация значений sort, если у всех элементов они равны 0.
     */
    protected function initializeSortValues(): void
    {
        $products = Product::all();
        if ($products->every(fn($product) => $product->sort === 0)) {
            foreach ($products as $index => $product) {
                $product->sort = $index + 1; // Уникальное значение для каждого элемента
                $product->save();
            }
        }
    }

}
