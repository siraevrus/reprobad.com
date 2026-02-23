<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileManagerController extends Controller
{
    public function index()
    {
        $files = collect(Storage::disk('public')->files('uploads'))->map(function ($file) {
            return [
                'name' => basename($file),
                'path' => $file,
                'url' => Storage::disk('public')->url($file),
                'size' => Storage::disk('public')->size($file),
                'modified' => Storage::disk('public')->lastModified($file),
            ];
        })->sortByDesc('modified');

        return view('admin.file-manager.index', compact('files'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp,svg,pdf|max:10240',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads', $fileName, 'public');

        return response()->json([
            'success' => true,
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    /**
     * Загрузка изображения из base64 (data URL) в файл. Возвращает URL сохранённого файла.
     */
    public function uploadBase64(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // data:image/jpeg;base64,... или data:image/png;base64,...
        ]);

        $dataUrl = $request->input('image');
        if (!str_starts_with($dataUrl, 'data:image/')) {
            return response()->json(['success' => false, 'message' => 'Недопустимый формат изображения'], 422);
        }

        try {
            $format = str_contains($dataUrl, 'image/png') ? 'png' : 'jpg';
            $url = ImageService::resize($dataUrl, $format, 'menu-images');
            return response()->json(['success' => true, 'url' => $url]);
        } catch (\Exception $e) {
            \Log::error('uploadBase64 error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Ошибка сохранения изображения'], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // максимум 10MB
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        $path = $file->storeAs('uploads', $fileName, 'public');

        return redirect()->route('admin.file-manager.index')
            ->with('success', 'Файл успешно загружен');
    }

    public function destroy($filename)
    {
        $path = 'uploads/' . $filename;
        
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return redirect()->route('admin.file-manager.index')
                ->with('success', 'Файл успешно удален');
        }

        return redirect()->route('admin.file-manager.index')
            ->with('error', 'Файл не найден');
    }
} 