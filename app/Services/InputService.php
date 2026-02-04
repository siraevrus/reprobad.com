<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class InputService
{
    /**
     * @param $fileBase64
     * @param $resource
     * @param $field
     * @return bool
     */
    public static function uploadFile($fileBase64, $resource, $field): bool
    {
        if($fileBase64 == '') {
            $resource->$field = '';
            $resource->save();
        }

        if(!is_string($fileBase64) || empty($fileBase64)) return false;

        $exploded = explode('base64,', $fileBase64);
        if(count($exploded) < 2) return false;
        
        list($metaData, $fileBase64) = $exploded;
        preg_match('/data:(.*?);/', $metaData, $matches);
        $mimeType = $matches[1] ?? 'application/octet-stream';
        
        // Маппинг MIME типов к расширениям
        $mimeToExtension = [
            'image/svg+xml' => 'svg',
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'application/pdf' => 'pdf',
        ];
        
        // Если есть в маппинге - используем его, иначе извлекаем из MIME типа
        if (isset($mimeToExtension[$mimeType])) {
            $extension = $mimeToExtension[$mimeType];
        } else {
            $extension = explode('/', $mimeType)[1];
            // Убираем все после + (например, svg+xml -> svg)
            if (str_contains($extension, '+')) {
                $extension = explode('+', $extension)[0];
            }
        }

        $class_name = strtolower(class_basename($resource));
        $path = $class_name . '/' . $resource->id . '/' . uniqid() . '.' . $extension;

        Storage::disk('public')->put($path, base64_decode($fileBase64));

        $resource->$field = '/storage/' . $path;
        $resource->save();

        return true;
    }

    /**
     * @param $images
     * @param $resource
     * @param $field
     * @return bool
     */
    public static function uploadGallery($images, $resource, $field): bool
    {
        if(!is_array($images)) {
            // Если images не массив, не обновляем поле
            return false;
        }

        $processedImages = [];
        foreach ($images as $key => $image) {
            if(isset($image['remove']) && $image['remove'] === true) {
                // Удаляем файл, если он был загружен ранее
                if(isset($image['url']) && !str_contains($image['url'], 'data:')) {
                    $filePath = str_replace('/storage/', '', $image['url']);
                    Storage::disk('public')->delete($filePath);
                }
                continue; // Пропускаем удаленные изображения
            }
            
            // Если изображение уже загружено (не base64), просто добавляем его
            if(isset($image['url']) && !str_contains($image['url'], 'data:')) {
                $processedImages[] = $image;
                continue;
            }
            
            // Обрабатываем новые изображения (base64)
            if(isset($image['url']) && str_contains($image['url'], 'data:')) {
                try {
                    $class_name = strtolower(class_basename($resource));
                    $path = ImageService::resize($image['url'], 'png', $class_name . '/' . $resource->id);
                    $processedImages[] = [
                        'url' => $path,
                        'name' => $image['name'] ?? basename($path)
                    ];
                } catch (\Exception $e) {
                    // Логируем ошибку, но продолжаем обработку остальных изображений
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
