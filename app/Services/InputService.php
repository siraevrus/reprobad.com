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
        if(!is_array($images)) return false;

        foreach ($images as $key => $image) {
            if(isset($image['remove']) && $image['remove'] === true) {
                Storage::disk('public')->delete($image['url']);
                unset($images[$key]);
                continue;
            }
            if(!str_contains($image['url'], 'data:')) continue;
            $class_name = strtolower(class_basename($resource));
            $path = ImageService::resize($image['url'], 'png', $class_name . '/' . $resource->id);
            $images[$key]['url'] = $path;
        }
        $resource->$field = $images;
        $resource->save();

        return true;
    }
}
