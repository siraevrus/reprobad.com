<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProductController extends Controller
{

    public array $rules = [
        'title' => 'required',
        'content' => 'string|nullable',
        'alias' => 'required|unique:articles,alias',
        'description' => 'nullable',
        'image' => 'string|nullable',
        'logo' => 'string|nullable',
        'includes' => 'string|nullable',
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
        'seo_description' => 'string|nullable',
    ];

    public function index(): View
    {
        $resources = Product::sorted()->paginate(env('PAGINATION_LIMIT', 20));
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

        $resource = Product::query()
            ->create($validator->validated());
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

        $resource = Product::query()->findOrFail($id);
        $resource->fill($validator->validated());
        $resource->save();

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
