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
        // Если файл пустой или null, очищаем поле и выходим
        if(empty($fileBase64) || $fileBase64 === null || $fileBase64 === '') {
            $resource->$field = '';
            $resource->save();
            return true;
        }

        // Проверяем, что это строка
        if(!is_string($fileBase64)) {
            return false;
        }

        // Проверяем формат base64
        $exploded = explode('base64,', $fileBase64);
        if(count($exploded) < 2) {
            return false;
        }
        
        list($metaData, $fileBase64Data) = $exploded;
        
        // Проверяем, что есть данные после base64,
        if(empty($fileBase64Data)) {
            return false;
        }
        
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
            $mimeParts = explode('/', $mimeType);
            if(count($mimeParts) < 2) {
                return false;
            }
            $extension = $mimeParts[1];
            // Убираем все после + (например, svg+xml -> svg)
            if (str_contains($extension, '+')) {
                $extension = explode('+', $extension)[0];
            }
        }

        try {
            $class_name = strtolower(class_basename($resource));
            $path = $class_name . '/' . $resource->id . '/' . uniqid() . '.' . $extension;

            // Декодируем base64
            $decodedData = base64_decode($fileBase64Data, true);
            if($decodedData === false) {
                \Log::error('Failed to decode base64 data for field: ' . $field);
                return false;
            }

            // Сохраняем файл
            Storage::disk('public')->put($path, $decodedData);

            $resource->$field = '/storage/' . $path;
            $resource->save();

            return true;
        } catch (\Exception $e) {
            \Log::error('Error uploading file for field ' . $field . ': ' . $e->getMessage());
            return false;
        }
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
