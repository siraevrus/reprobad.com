<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\InputService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EventController extends Controller
{
    public array $rules = [
        'title' => 'required|string',
        'content' => 'required|string',
        'alias' => 'required|unique:events,alias',
        'description' => 'string|nullable',
        'image' => 'string|nullable',
        'images' => 'array|nullable',
        'category' => 'string|nullable',
        'file' => 'string|nullable',
        'logo' => 'string|nullable',
        'date' => 'string|nullable',
        'dates' => 'string|nullable',
        'address' => 'string|nullable',
        'phone' => 'string|nullable',
        'email' => 'string|nullable'
    ];

    public function index(): View|JsonResponse
    {
        $resources = Event::query()->paginate(env('PAGINATION_LIMIT', 20));

        if(request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.events.index', compact('resources'));
    }

    public function show(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');
        $resource = Event::query()->findOrFail($id);
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

        $resource = Event::query()
            ->create($validator->validated());

        InputService::uploadGallery($request->images, $resource, 'images');
        InputService::uploadFile($request->file, $resource, 'file');

        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), array_merge($this->rules, [
            'alias' => 'required|unique:events,alias,' . $id,
        ]));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $resource = Event::query()->findOrFail($id);
        $resource->fill($validator->validated());
        $resource->save();

        InputService::uploadGallery($request->images, $resource, 'images');
        InputService::uploadFile($request->file, $resource, 'file');

        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $resource = Event::query()->findOrFail($id);
        $resource->delete();
        return back();
    }

    public function create(): View
    {
        return view('admin.events.create');
    }

    public function edit(): View
    {
        return view('admin.events.create');
    }

    public function switch($id): RedirectResponse
    {
        $resource = Event::query()->findOrFail($id);
        $resource->active = $resource->active === 0;
        $resource->save();
        session()->flash('message', 'Статус публикации обновлен');
        return back();
    }

    public function home($id): RedirectResponse
    {
        $resource = Event::findOrFail($id);
        $resource->home = $resource->home == false;
        $resource->save();
        session()->flash('message', 'Элементы на главной странице обновлены');
        return back();
    }
}
