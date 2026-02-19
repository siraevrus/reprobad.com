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
        try {
            $request->headers->set('Accept', 'application/json');

            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            $imageFields = ['image', 'icon'];
            $dataForSave = array_diff_key($validated, array_flip($imageFields));

            $resource = Article::query()->create($dataForSave);

            $imageUploaded = false;
            $iconUploaded = false;

            if ($request->has('image') && $request->image && is_string($request->image) && str_starts_with($request->image, 'data:')) {
                $imageUploaded = InputService::uploadFile($request->image, $resource, 'image');
                \Log::info("New article {$resource->id}: image upload result = " . ($imageUploaded ? 'success' : 'failed'));
            }

            if ($request->has('icon') && $request->icon && is_string($request->icon) && str_starts_with($request->icon, 'data:')) {
                $iconUploaded = InputService::uploadFile($request->icon, $resource, 'icon');
            }

            $resource->refresh();

            return response()->json([
                'success' => true,
                'resource' => $resource,
                'debug' => [
                    'image_uploaded' => $imageUploaded,
                    'icon_uploaded' => $iconUploaded,
                    'image_value' => $resource->image,
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error("Article store error: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'errors' => ['server' => ['Ошибка сервера: ' . $e->getMessage()]]
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $debug = ['steps' => []];

        try {
            $request->headers->set('Accept', 'application/json');

            $rawImage = $request->input('image');
            $debug['request_has_image'] = $request->has('image');
            $debug['image_type'] = gettype($rawImage);
            $debug['image_length'] = is_string($rawImage) ? strlen($rawImage) : 0;
            $debug['image_starts_with_data'] = is_string($rawImage) && strlen($rawImage) > 5 ? substr($rawImage, 0, 30) : $rawImage;

            $validator = Validator::make($request->all(), array_merge($this->rules, [
                'alias' => 'required|unique:articles,alias,' . $id,
            ]));

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'debug' => $debug
                ], 422);
            }

            $debug['steps'][] = 'validation_passed';

            $validated = $validator->validated();

            $imageFields = ['image', 'icon'];
            $dataForSave = array_diff_key($validated, array_flip($imageFields));

            $resource = Article::query()->findOrFail($id);
            $debug['image_before'] = $resource->image;
            $resource->fill($dataForSave);
            $resource->save();
            $debug['steps'][] = 'resource_saved';

            $imageUploaded = false;
            $isBase64 = is_string($rawImage) && str_starts_with($rawImage, 'data:');
            $debug['is_base64'] = $isBase64;

            if ($isBase64) {
                $debug['steps'][] = 'calling_uploadFile';
                $imageUploaded = InputService::uploadFile($rawImage, $resource, 'image');
                $debug['steps'][] = 'uploadFile_returned_' . ($imageUploaded ? 'true' : 'false');
                $debug['image_after_upload'] = $resource->image;
            } else {
                $debug['steps'][] = 'skipped_uploadFile_not_base64';
            }

            $resource->refresh();
            $debug['image_final'] = $resource->image;
            $debug['steps'][] = 'done';

            return response()->json([
                'success' => true,
                'resource' => $resource,
                'debug' => $debug
            ]);
        } catch (\Exception $e) {
            $debug['steps'][] = 'exception: ' . $e->getMessage();
            \Log::error("Article update error for {$id}: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'errors' => ['server' => ['Ошибка сервера: ' . $e->getMessage()]],
                'debug' => $debug
            ], 500);
        }
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
