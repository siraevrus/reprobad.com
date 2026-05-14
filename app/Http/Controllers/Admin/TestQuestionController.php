<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestQuestion;
use App\Support\ReproTestBlocks;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class TestQuestionController extends Controller
{
    public array $rules = [
        'question_text' => 'required|string',
        'order' => 'required|integer|min:1|max:24',
        'block_number' => 'required|integer|in:1,2,3,4',
        'answers' => 'required|array|min:2',
        'answers.*.text' => 'required|string',
        'answers.*.value' => 'required|integer|min:0|max:3',
        'active' => 'boolean',
    ];

    /**
     * Проверить, что баллы вариантов уникальны (каждое значение 0..3 встречается не более одного раза).
     * После прохождения проверки массив возвращается отсортированным по value ASC.
     *
     * @param  array<int, array<string, mixed>>  $answers
     * @return array{0: bool, 1: array<int, array<string, mixed>>|string}
     */
    private function normalizeAnswersOrFail(array $answers): array
    {
        $seen = [];
        foreach ($answers as $a) {
            $v = (int) ($a['value'] ?? 0);
            if (isset($seen[$v])) {
                return [false, 'Баллы вариантов должны быть уникальными. Используйте 0, 1, 2, 3 — каждый ровно один раз.'];
            }
            $seen[$v] = true;
        }

        return [true, TestQuestion::normalizeAnswers($answers)];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        $resources = TestQuestion::query()
            ->ordered()
            ->paginate(env('PAGINATION_LIMIT', 50));

        if (request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.test-questions.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.test-questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['active'] = $request->has('active') ? (bool) $request->input('active') : true;

        [$ok, $payload] = $this->normalizeAnswersOrFail($validated['answers']);
        if (! $ok) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['answers' => [$payload]],
                ], 422);
            }

            return back()->withErrors(['answers' => $payload])->withInput();
        }
        $validated['answers'] = $payload;

        $expectedBlock = ReproTestBlocks::blockForQuestionOrder((int) $validated['order']);
        if ((int) $validated['block_number'] !== $expectedBlock) {
            $msg = 'Блок должен соответствовать номеру вопроса: 1–6 → блок 1, 7–14 → 2, 15–19 → 3, 20–24 → 4.';
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['block_number' => [$msg]],
                ], 422);
            }

            return back()->withErrors(['block_number' => $msg])->withInput();
        }

        // Проверяем уникальность порядка
        $existing = TestQuestion::where('order', $validated['order'])->first();
        if ($existing) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['order' => ['Вопрос с таким порядком уже существует']],
                ], 422);
            }

            return back()->withErrors(['order' => 'Вопрос с таким порядком уже существует'])->withInput();
        }

        $resource = TestQuestion::query()->create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'resource' => $resource,
            ]);
        }

        return redirect()->route('admin.test-questions.create')
            ->with('message', 'Вопрос создан успешно');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View|JsonResponse
    {
        $resource = TestQuestion::query()->findOrFail($id);

        if (request()->ajax()) {
            return response()->json($resource);
        }

        return view('admin.test-questions.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $resource = TestQuestion::query()->findOrFail($id);

        return view('admin.test-questions.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse|RedirectResponse
    {
        $rules = $this->rules;
        $rules['order'] = 'required|integer|min:1|max:24';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['active'] = $request->has('active') ? (bool) $request->input('active') : true;

        [$ok, $payload] = $this->normalizeAnswersOrFail($validated['answers']);
        if (! $ok) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['answers' => [$payload]],
                ], 422);
            }

            return back()->withErrors(['answers' => $payload])->withInput();
        }
        $validated['answers'] = $payload;

        $expectedBlock = ReproTestBlocks::blockForQuestionOrder((int) $validated['order']);
        if ((int) $validated['block_number'] !== $expectedBlock) {
            $msg = 'Блок должен соответствовать номеру вопроса: 1–6 → блок 1, 7–14 → 2, 15–19 → 3, 20–24 → 4.';
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['block_number' => [$msg]],
                ], 422);
            }

            return back()->withErrors(['block_number' => $msg])->withInput();
        }

        $resource = TestQuestion::query()->findOrFail($id);

        // Проверяем уникальность порядка (кроме текущего вопроса)
        $existing = TestQuestion::where('order', $validated['order'])
            ->where('id', '!=', $id)
            ->first();
        if ($existing) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['order' => ['Вопрос с таким порядком уже существует']],
                ], 422);
            }

            return back()->withErrors(['order' => 'Вопрос с таким порядком уже существует'])->withInput();
        }

        $resource->fill($validated);
        $resource->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'resource' => $resource,
            ]);
        }

        return redirect()->route('admin.test-questions.index')
            ->with('message', 'Вопрос обновлен успешно');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $resource = TestQuestion::query()->findOrFail($id);
        $resource->delete();

        return redirect()->route('admin.test-questions.index')
            ->with('message', 'Вопрос удален');
    }
}
