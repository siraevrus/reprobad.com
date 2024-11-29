<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    public function index(): JsonResponse
    {
        $resources = Article::all();
        return response()->json($resources);
    }

    public function show($id): JsonResponse
    {
        $resource = Article::query()->findOrFail($id);
        return response()->json($resource);
    }

    public function update($id): JsonResponse
    {
        $resource = Article::query()->findOrFail($id);
        $resource->fill(request()->all());
        $resource->save();
        return response()->json($resource);
    }

    public function delete($id): JsonResponse
    {
        $resource = Article::query()->findOrFail($id);
        $resource->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
