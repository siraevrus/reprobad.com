<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PointController extends Controller
{

    public array $rules = [
        'coords' => 'string|required',
        'title' => 'string|required',
        'subtitle' => 'string|nullable',
        'address' => 'string|nullable',
        'metro' => 'string|nullable',
        'text' => 'string|nullable',
        'image' => 'string|nullable',
        'active' => 'boolean|required',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $resources = Point::query()->paginate(env('PAGINATION_LIMIT', 20));
        return view('admin.points.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.points.create');
    }

    public function edit(): View
    {
        return view('admin.points.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
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
        if($validated['image']) $validated['image'] = ImageService::resize($validated['image']);

        $resource = Point::query()
            ->create($validated);
        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');
        $resource = Point::query()->findOrFail($id);
        return response()->json($resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
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
        if($validated['image']) $validated['image'] = ImageService::resize($validated['image']);

        $resource = Point::query()->findOrFail($id);
        $resource->fill($validated);
        $resource->save();

        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $resource = Point::query()->findOrFail($id);
        $resource->delete();
        return back();
    }

    public function switch($id): RedirectResponse
    {
        $resource = Point::query()->findOrFail($id);
        $resource->active = $resource->active === 0;
        $resource->save();
        session()->flash('message', 'Статус публикации обновлен');
        return back();
    }
}
