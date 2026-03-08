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
        'seo_title' => 'string|nullable',
        'seo_description' => 'string|nullable',
        'image' => 'string|nullable',
        'image_alt' => 'string|nullable',
        'images' => 'array|nullable',
        'category' => 'string|nullable',
        'file' => 'string|nullable',
        'logo' => 'string|nullable',
        'logo_alt' => 'string|nullable',
        'date' => 'string|nullable',
        'dates' => 'string|nullable',
        'address' => 'string|nullable',
        'phone' => 'string|nullable',
        'email' => 'string|nullable'
    ];

    public function index(): View|JsonResponse
    {
        // Загружаем только нужные поля, исключая большие (content, images, image, logo)
        // Поля image и logo содержат base64-данные размером до 9.6 МБ, что вызывает ошибки памяти
        $resources = Event::sorted()
            ->select('id', 'title', 'created_at', 'sort', 'active', 'home', 'alias')
            ->paginate(env('PAGINATION_LIMIT', 20));

        if(request()->ajax()) {
            return response()->json($resources);
        }

        return view('admin.events.index', compact('resources'));
    }

    public function show(Request $request, $id): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');
        $resource = Event::query()->findOrFail($id);
        $data = $resource->toArray();
        $data = $this->makeAssetUrlsAbsolute($data, ['logo', 'image', 'file']);
        return response()->json($data);
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

        $validated = $validator->validated();

        // Исключаем поля с изображениями из validated, чтобы не сохранять base64 в БД
        // Это предотвращает проблемы с памятью при работе с большими base64 строками
        $imageFields = ['image', 'images', 'file', 'logo'];
        $dataForSave = array_diff_key($validated, array_flip($imageFields));

        $resource = Event::query()
            ->create($dataForSave);

        // Обработка изображений через InputService (конвертирует base64 в файлы)
        InputService::uploadFile($request->input('image'), $resource, 'image');
        InputService::uploadGallery($request->input('images'), $resource, 'images');
        InputService::uploadFile($request->input('file'), $resource, 'file');
        InputService::uploadFile($request->input('logo'), $resource, 'logo');

        $resourceData = $resource->fresh()->toArray();
        $resourceData = $this->makeAssetUrlsAbsolute($resourceData, ['logo', 'image', 'file']);

        return response()->json([
            'success' => true,
            'resource' => $resourceData
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

        $validated = $validator->validated();

        // Исключаем поля с изображениями из validated, чтобы не сохранять base64 в БД
        // Это предотвращает проблемы с памятью при работе с большими base64 строками
        $imageFields = ['image', 'images', 'file', 'logo'];
        $dataForSave = array_diff_key($validated, array_flip($imageFields));

        $resource = Event::query()->findOrFail($id);
        $resource->fill($dataForSave);
        $resource->save();

        // Обработка изображений через InputService (конвертирует base64 в файлы)
        InputService::uploadFile($request->input('image'), $resource, 'image');
        InputService::uploadGallery($request->input('images'), $resource, 'images');
        InputService::uploadFile($request->input('file'), $resource, 'file');
        InputService::uploadFile($request->input('logo'), $resource, 'logo');

        $resourceData = $resource->fresh()->toArray();
        $resourceData = $this->makeAssetUrlsAbsolute($resourceData, ['logo', 'image', 'file']);

        return response()->json([
            'success' => true,
            'resource' => $resourceData
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

    public function up(Request $request, $id): RedirectResponse
    {
        $this->initializeSortValues(); // Проверка и инициализация sort

        $resource = Event::findOrFail($id);
        $resourceAbove = Event::where('sort', '<', $resource->sort)
            ->orderBy('sort', 'desc')
            ->first();

        if ($resourceAbove) {
            $tempOrder = $resource->sort;
            $resource->sort = $resourceAbove->sort;
            $resourceAbove->sort = $tempOrder;
            $resourceAbove->save();
        }
        $resource->save();
        session()->flash('message', 'Порядок элементов обновлен');
        return back();
    }

    public function down(Request $request, $id): RedirectResponse
    {
        $this->initializeSortValues(); // Проверка и инициализация sort

        $resource = Event::findOrFail($id);
        $resourceBelow = Event::where('sort', '>', $resource->sort)
            ->orderBy('sort', 'asc')
            ->first();

        if ($resourceBelow) {
            $tempOrder = $resource->sort;
            $resource->sort = $resourceBelow->sort;
            $resourceBelow->sort = $tempOrder;
            $resourceBelow->save();
        }
        $resource->save();
        session()->flash('message', 'Порядок элементов обновлен');
        return back();
    }

    /**
     * Преобразует относительные пути к файлам в абсолютные URL для корректной загрузки в админке.
     * Не трогает base64 (data:...) и уже абсолютные URL.
     */
    protected function makeAssetUrlsAbsolute(array $data, array $fields): array
    {
        foreach ($fields as $field) {
            $val = $data[$field] ?? null;
            if (empty($val) || !is_string($val)) {
                continue;
            }
            // base64 data URL — оставляем как есть (для img src подходит)
            if (str_starts_with($val, 'data:')) {
                continue;
            }
            // уже абсолютный URL — не меняем
            if (str_starts_with($val, 'http')) {
                continue;
            }
            // относительный путь — делаем абсолютный URL
            $data[$field] = asset(ltrim($val, '/'));
        }
        return $data;
    }

    /**
     * Инициализация значений sort, если у всех элементов они равны 0.
     */
    protected function initializeSortValues(): void
    {
        // Проверяем только количество элементов с sort = 0, без загрузки всех данных
        $countWithZeroSort = Event::where('sort', 0)->count();
        $totalCount = Event::count();
        
        if ($countWithZeroSort === $totalCount && $totalCount > 0) {
            // Используем chunk для обработки больших объемов данных по частям
            $index = 0;
            Event::orderBy('id')->chunk(100, function ($events) use (&$index) {
                foreach ($events as $event) {
                    $event->sort = $index + 1;
                    $event->save();
                    $index++;
                }
            });
        }
    }
}
