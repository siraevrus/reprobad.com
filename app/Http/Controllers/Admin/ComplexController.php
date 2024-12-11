<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complex;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ComplexController extends Controller
{

    public array $rules = [
        'title' => 'required|string',
        'alias' => 'required|string|unique:complex,alias',
        'subtitle' => 'string|nullable',
        'content' => 'string|nullable',
        'image_left' => 'string|nullable',
        'image_right' => 'string|nullable',
        'title_left' => 'string|nullable',
        'title_right' => 'string|nullable',
        'description' => 'string|nullable',
        'color' => 'string|nullable',
        'products' => 'string|nullable',
    ];

    public function index(): View
    {
        $resources = Complex::query()->paginate(env('PAGINATION_LIMIT', 20));
        return view('admin.complex.index', compact('resources'));
    }

    public function show(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');
        $resource = Complex::query()->findOrFail($id);
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

        $resource = Complex::query()
            ->create($validator->validated());

        if($request->get('products')) {
            $productIds = array_filter(array_map('trim', explode(',', $request->products)));
            Product::query()->whereIn('id', $productIds)->update(['complex_id' => $resource->id]);
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
            'alias' => 'required|unique:complex,alias,' . $id,
        ]));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $resource = Complex::query()->findOrFail($id);
        $resource->fill($validator->validated());
        $resource->save();

        if($request->get('products')) {
            $productIds = array_filter(array_map('trim', explode(',', $request->products)));
            Product::query()->whereIn('id', $productIds)->update(['complex_id' => $resource->id]);
        }

        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $resource = Complex::query()->findOrFail($id);
        $resource->delete();
        return back();
    }

    public function create(): View
    {
        return view('admin.complex.create');
    }

    public function edit(): View
    {
        return view('admin.complex.create');
    }

    public function switch($id): RedirectResponse
    {
        $resource = Complex::query()->findOrFail($id);
        $resource->active = $resource->active === 0;
        $resource->save();
        return back();
    }
}
