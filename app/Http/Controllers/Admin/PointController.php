<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Point;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PointController extends Controller
{
    public array $rules = [
        'coords' => [
            'regex:/^-?\d{1,3}(\.\d+)?,\-?\d{1,3}(\.\d+)?$/',
            'required'
        ],
        'title' => 'string|required',
        'subtitle' => 'string|nullable',
        'address' => 'string|nullable',
        'metro' => 'string|nullable',
        'text' => 'string|nullable',
        'image' => 'string|nullable',
        'phone' => 'string|nullable',
        'days' => 'string|nullable',
        'time' => 'string|nullable',
        'city' => 'string|nullable',
        'site' => 'url|nullable',
        'active' => 'boolean|required',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if(request()->user()->cannot('viewAny', Point::class)) abort(403);
        $resources = Point::query()->paginate(env('PAGINATION_LIMIT', 20));

        if(request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.points.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        if(request()->user()->cannot('create', Point::class)) abort(403);
        return view('admin.points.create');
    }

    public function edit($id): View
    {
        $resource = Point::query()->findOrFail($id);
        if(request()->user()->cannot('update', $resource)) abort(403);
        return view('admin.points.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if(request()->user()->cannot('create', Point::class)) abort(403);

        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

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

        if(request()->user()->cannot('view', $resource)) abort(403);

        return response()->json($resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $resource = Point::query()->findOrFail($id);

        if(request()->user()->cannot('update', $resource)) abort(403);

        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $resource->fill($validated);
        $resource->save();

        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $resource = Point::query()->findOrFail($id);

        if(request()->user()->cannot('delete', $resource)) abort(403);

        $resource->delete();
        return back();
    }

    public function switch(Request $request, $id): RedirectResponse
    {
        $resource = Point::query()->findOrFail($id);

        if(request()->user()->cannot('update', $resource)) abort(403);

        $resource->active = $resource->active === 0;
        $resource->save();
        session()->flash('message', 'Статус публикации обновлен');
        return back();
    }
}
