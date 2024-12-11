<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ImageService;
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
        'category' => 'string|nullable',
        'time' => 'string|nullable',
    ];

    public function index(): View
    {
        $resources = Article::query()->paginate(env('PAGINATION_LIMIT', 20));
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

        $resource = Article::query()
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

        $validated = $validator->validated();
        if($validated['image']) $validated['image'] = ImageService::resize($validated['image']);

        $resource = Article::query()->findOrFail($id);
        $resource->fill($validated);
        $resource->save();

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
        return back();
    }
}
