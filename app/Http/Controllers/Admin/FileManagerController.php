<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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