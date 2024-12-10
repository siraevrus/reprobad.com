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

class PageController extends Controller
{
    public function index(): View
    {
        $resources = Page::query()->paginate(20);
        return view('admin.pages.index', compact('resources'));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function edit(): View
    {
        return view('admin.pages.create');
    }

    public function show($id): JsonResponse
    {
        $resource = Page::query()->findOrFail($id);
        return response()->json($resource);
    }

    public function store(Request $request) : JsonResponse
    {
        $request->headers->set('Accept', 'application/json');
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'alias' => 'required|unique:articles,alias',
            'description' => 'nullable',
            'active' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $resource = Page::query()->create($validator->validated());
        return response()->json($resource);
    }

    public function update(Request $request,$id): JsonResponse
    {
        request()->headers->set('Accept', 'application/json');

        $request->headers->set('Accept', 'application/json');
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'alias' => 'required|unique:articles,alias,' . $id,
            'description' => 'nullable',
            'active' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $resource = Page::query()->findOrFail($id);
        $resource->fill($validator->validated());
        $resource->save();
        return response()->json($resource);
    }

    public function delete($id): JsonResponse
    {
        $resource = Page::query()->findOrFail($id);
        $resource->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function switch($id): RedirectResponse
    {
        $resource = Page::query()->findOrFail($id);
        $resource->active = $resource->active === 0;
        $resource->save();
        return back();
    }
}
