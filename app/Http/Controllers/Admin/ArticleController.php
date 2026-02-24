<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
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

        $data = $validator->validated();
        $data['content'] = $this->normalizeEmbeds($data['content'] ?? '');

        $resource = Article::query()->create($data);

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

        $data = $validator->validated();
        $data['content'] = $this->normalizeEmbeds($data['content'] ?? '');

        $resource = Article::query()->findOrFail($id);
        $resource->fill($data);
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

    private function normalizeEmbeds(string $html): string
    {
        $result = preg_replace_callback(
            '/<iframe\b[^>]*src=["\']https?:\/\/(?:www\.)?rutube\.ru\/play\/embed\/[^"\']+["\'][^>]*>/i',
            function (array $matches): string {
                $tag = $matches[0];

                // Remove sandbox to allow Rutube player scripts to run.
                $tag = preg_replace('/\s+sandbox(?:\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]+))?/i', '', $tag) ?? $tag;

                if (!preg_match('/\sallow(?:\s*=\s*(?:"[^"]*"|\'[^\']*\'))/i', $tag)) {
                    $tag = rtrim($tag, '>') . ' allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media">';
                }

                return $tag;
            },
            $html
        );

        return $result ?? $html;
    }
}
