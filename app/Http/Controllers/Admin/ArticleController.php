<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $resources = Article::query()->paginate(20);
        return view('admin.articles.index', compact('resources'));
    }

    public function show($id): JsonResponse
    {
        $resource = Article::query()->findOrFail($id);
        return response()->json($resource);
    }

    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'alias' => 'required|unique:articles,alias',
            'description' => 'nullable'
        ]);

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

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'alias' => 'required|unique:articles,alias,' . $id,
            'description' => 'nullable',
            'image' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $resource = Article::query()->findOrFail($id);
        $resource->fill($validator->validated());
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
        return view('admin.articles.create');
    }

    public function edit(): View
    {
        return view('admin.articles.edit');
    }
}
