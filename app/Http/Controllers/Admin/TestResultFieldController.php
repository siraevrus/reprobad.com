<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestResultField;
use App\Services\InputService;
use App\Support\ReproTestBlocks;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class TestResultFieldController extends Controller
{
    public array $rules = [
        'field_number' => 'required|integer|min:1|max:9',
        'block_number' => 'required|integer|in:1,2,3,4',
        'description' => 'required|string|max:5000',
        'popup_html' => 'nullable|string|max:100000',
        'email_description' => 'nullable|string|max:10000',
        'color' => 'nullable|string|in:green,lavender,orange',
        'image1' => 'nullable|string', // base64 или путь к существующему файлу
        'link1' => 'nullable|url|max:500',
        'image2' => 'nullable|string', // base64 или путь к существующему файлу
        'link2' => 'nullable|url|max:500',
        'active' => 'boolean',
        'order' => 'integer|min:0',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        $resources = TestResultField::query()
            ->ordered()
            ->paginate(env('PAGINATION_LIMIT', 50));

        if (request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.test-result-fields.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.test-result-fields.create');
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
        $expectedBlock = ReproTestBlocks::blockForFieldNumber((int) $validated['field_number']);
        if ($expectedBlock !== null && (int) $validated['block_number'] !== $expectedBlock) {
            $msg = 'Блок должен соответствовать номеру поля: поля 1–2 → блок 1, 3–5 → 2, 6–7 → 3, 8–9 → 4.';
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['block_number' => [$msg]],
                ], 422);
            }

            return back()->withErrors(['block_number' => $msg])->withInput();
        }

        $validated['active'] = $request->has('active') ? (bool) $request->input('active') : true;
        $validated['order'] = $request->input('order', 0);

        // Проверяем уникальность field_number
        $existing = TestResultField::where('field_number', $validated['field_number'])->first();
        if ($existing) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['field_number' => ['Поле с таким номером уже существует']],
                ], 422);
            }

            return back()->withErrors(['field_number' => 'Поле с таким номером уже существует'])->withInput();
        }

        // Создаем ресурс
        $resource = TestResultField::query()->create([
            'field_number' => $validated['field_number'],
            'block_number' => $validated['block_number'],
            'description' => $validated['description'],
            'popup_html' => $validated['popup_html'] ?? null,
            'email_description' => $validated['email_description'] ?? null,
            'color' => $validated['color'] ?? null,
            'active' => $validated['active'],
            'order' => $validated['order'],
        ]);

        // Загружаем изображения через InputService только если они переданы и не пустые
        if ($request->filled('image1') && ! empty($request->image1)) {
            InputService::uploadFile($request->image1, $resource, 'image1');
        }
        if ($request->filled('image2') && ! empty($request->image2)) {
            InputService::uploadFile($request->image2, $resource, 'image2');
        }

        // Сохраняем ссылки
        if ($request->filled('link1')) {
            $resource->link1 = $request->link1;
        }
        if ($request->filled('link2')) {
            $resource->link2 = $request->link2;
        }
        $resource->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'resource' => $resource,
            ]);
        }

        return redirect()->route('admin.test-result-fields.create')
            ->with('message', 'Результат теста создан успешно');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View|JsonResponse
    {
        $resource = TestResultField::query()->findOrFail($id);

        if (request()->ajax()) {
            return response()->json($resource);
        }

        return view('admin.test-result-fields.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $resource = TestResultField::query()->findOrFail($id);

        return view('admin.test-result-fields.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse|RedirectResponse
    {
        $rules = $this->rules;

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
        $expectedBlock = ReproTestBlocks::blockForFieldNumber((int) $validated['field_number']);
        if ($expectedBlock !== null && (int) $validated['block_number'] !== $expectedBlock) {
            $msg = 'Блок должен соответствовать номеру поля: поля 1–2 → блок 1, 3–5 → 2, 6–7 → 3, 8–9 → 4.';
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['block_number' => [$msg]],
                ], 422);
            }

            return back()->withErrors(['block_number' => $msg])->withInput();
        }

        $validated['active'] = $request->has('active') ? (bool) $request->input('active') : true;
        $validated['order'] = $request->input('order', 0);

        $resource = TestResultField::query()->findOrFail($id);

        // Проверяем уникальность field_number (кроме текущего поля)
        $existing = TestResultField::where('field_number', $validated['field_number'])
            ->where('id', '!=', $id)
            ->first();
        if ($existing) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['field_number' => ['Поле с таким номером уже существует']],
                ], 422);
            }

            return back()->withErrors(['field_number' => 'Поле с таким номером уже существует'])->withInput();
        }

        // Обновляем основные поля
        $resource->fill([
            'field_number' => $validated['field_number'],
            'block_number' => $validated['block_number'],
            'description' => $validated['description'],
            'popup_html' => $validated['popup_html'] ?? null,
            'email_description' => $validated['email_description'] ?? null,
            'color' => $validated['color'] ?? null,
            'active' => $validated['active'],
            'order' => $validated['order'],
        ]);

        // Обновляем ссылки
        $resource->link1 = $request->input('link1');
        $resource->link2 = $request->input('link2');
        $resource->save();

        // Обработка удаления изображений
        if ($request->input('image1_delete') == '1') {
            // Удаляем файл из хранилища
            if ($resource->image1) {
                $filePath = str_replace('/storage/', '', $resource->image1);
                Storage::disk('public')->delete($filePath);
            }
            $resource->image1 = null;
            $resource->save();
        } else {
            // Загружаем новое изображение только если оно передано и не пустое
            if ($request->filled('image1') && ! empty($request->image1)) {
                InputService::uploadFile($request->image1, $resource, 'image1');
            }
        }

        if ($request->input('image2_delete') == '1') {
            // Удаляем файл из хранилища
            if ($resource->image2) {
                $filePath = str_replace('/storage/', '', $resource->image2);
                Storage::disk('public')->delete($filePath);
            }
            $resource->image2 = null;
            $resource->save();
        } else {
            // Загружаем новое изображение только если оно передано и не пустое
            if ($request->filled('image2') && ! empty($request->image2)) {
                InputService::uploadFile($request->image2, $resource, 'image2');
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'resource' => $resource,
            ]);
        }

        return redirect()->route('admin.test-result-fields.index')
            ->with('message', 'Результат теста обновлен успешно');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $resource = TestResultField::query()->findOrFail($id);
        $resource->delete();

        return redirect()->route('admin.test-result-fields.index')
            ->with('message', 'Результат теста удален');
    }
}
