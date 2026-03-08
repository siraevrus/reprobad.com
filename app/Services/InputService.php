<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class InputService
{
    public static string $lastError = '';

    public static function uploadFile($fileBase64, $resource, $field): bool
    {
        self::$lastError = '';

        if(empty($fileBase64) || $fileBase64 === null || $fileBase64 === '') {
            $resource->$field = '';
            $resource->save();
            return true;
        }

        if(!is_string($fileBase64)) {
            self::$lastError = 'not_a_string: ' . gettype($fileBase64);
            return false;
        }

        // Если это не base64 (уже существующий URL или путь), сохраняем путь для единообразия
        if(!str_starts_with($fileBase64, 'data:')) {
            // Нормализуем полный URL к относительному пути для хранения в БД
            $path = $fileBase64;
            if (str_starts_with($fileBase64, 'http')) {
                $parsed = parse_url($fileBase64);
                $path = $parsed['path'] ?? $fileBase64;
            }
            $resource->$field = $path;
            $resource->save();
            return true;
        }

        $exploded = explode('base64,', $fileBase64);
        if(count($exploded) < 2) {
            self::$lastError = 'no_base64_separator';
            return false;
        }
        
        list($metaData, $fileBase64Data) = $exploded;
        
        if(empty($fileBase64Data)) {
            self::$lastError = 'empty_base64_data';
            return false;
        }
        
        preg_match('/data:(.*?);/', $metaData, $matches);
        $mimeType = $matches[1] ?? 'application/octet-stream';
        
        $mimeToExtension = [
            'image/svg+xml' => 'svg',
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'application/pdf' => 'pdf',
        ];
        
        if (isset($mimeToExtension[$mimeType])) {
            $extension = $mimeToExtension[$mimeType];
        } else {
            $mimeParts = explode('/', $mimeType);
            if(count($mimeParts) < 2) {
                self::$lastError = 'bad_mime: ' . $mimeType;
                return false;
            }
            $extension = $mimeParts[1];
            if (str_contains($extension, '+')) {
                $extension = explode('+', $extension)[0];
            }
        }

        $class_name = strtolower(class_basename($resource));
        $path = $class_name . '/' . $resource->id . '/' . uniqid() . '.' . $extension;

        $decodedData = base64_decode($fileBase64Data, true);
        if($decodedData === false) {
            self::$lastError = 'base64_decode_failed';
            return false;
        }

        try {
            Storage::disk('public')->put($path, $decodedData);
        } catch (\Exception $e) {
            self::$lastError = 'storage_put_error: ' . $e->getMessage();
            return false;
        }

        $fullPath = Storage::disk('public')->path($path);
        if (!file_exists($fullPath)) {
            self::$lastError = 'file_not_created: ' . $fullPath;
            return false;
        }

        $resource->$field = '/storage/' . $path;
        
        try {
            $resource->save();
        } catch (\Exception $e) {
            self::$lastError = 'db_save_error: ' . $e->getMessage();
            return false;
        }

        return true;
    }

    public static function uploadGallery($images, $resource, $field): bool
    {
        if(!is_array($images)) {
            return false;
        }

        $processedImages = [];
        foreach ($images as $key => $image) {
            if(isset($image['remove']) && $image['remove'] === true) {
                if(isset($image['url']) && !str_contains($image['url'], 'data:')) {
                    $filePath = str_replace('/storage/', '', $image['url']);
                    Storage::disk('public')->delete($filePath);
                }
                continue;
            }
            if(isset($image['url']) && !str_contains($image['url'], 'data:')) {
                $processedImages[] = [
                    'url' => $image['url'],
                    'name' => $image['name'] ?? basename($image['url']),
                    'alt' => $image['alt'] ?? '',
                ];
                continue;
            }
            if(isset($image['url']) && str_contains($image['url'], 'data:')) {
                try {
                    $class_name = strtolower(class_basename($resource));
                    $path = ImageService::resize($image['url'], 'png', $class_name . '/' . $resource->id);
                    $processedImages[] = [
                        'url' => $path,
                        'name' => $image['name'] ?? basename($path),
                        'alt' => $image['alt'] ?? '',
                    ];
                } catch (\Exception $e) {
                    \Log::error('Error processing image in gallery: ' . $e->getMessage());
                    continue;
                }
            }
        }
        
        $resource->$field = $processedImages;
        $resource->save();

        return true;
    }
}
