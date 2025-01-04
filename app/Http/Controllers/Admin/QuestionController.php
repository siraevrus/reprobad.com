<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advise;
use App\Models\Article;
use App\Models\Question;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class QuestionController extends Controller
{

    public array $rules = [
        'title' => 'string|required',
        'text' => 'string|nullable',
        'icon' => 'string|nullable',
        'active' => 'boolean|required',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        $resources = Question::query()->paginate(env('PAGINATION_LIMIT', 20));

        if(request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.questions.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $articles = Article::query()->pluck('title', 'id');
        $advises = Advise::query()->pluck('title', 'id');
        $options = $articles->union($advises);
        return view('admin.questions.create', compact('options'));
    }

    public function edit(): View
    {
        $articles = Article::query()->pluck('title', 'id');
        $advises = Advise::query()->pluck('title', 'id');
        $options = $articles->union($advises);
        return view('admin.questions.create', compact('options'));
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

        $resource = Question::query()
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
        $resource = Question::query()->findOrFail($id);
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

        $resource = Question::query()->findOrFail($id);
        $resource->fill($validated);
        $resource->save();

        return response()->json([
            'success' => true,
            'resource' => $resource
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $resource = Question::query()->findOrFail($id);
        $resource->delete();
        return back();
    }

    public function switch($id): RedirectResponse
    {
        $resource = Question::query()->findOrFail($id);
        $resource->active = $resource->active === 0;
        $resource->save();
        session()->flash('message', 'Статус публикации обновлен');
        return back();
    }
}
