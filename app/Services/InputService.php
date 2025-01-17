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

        list($metaData, $fileBase64) = explode('base64,', $fileBase64);
        preg_match('/data:(.*?);/', $metaData, $matches);
        $mimeType = $matches[1] ?? 'application/octet-stream';
        $extension = explode('/', $mimeType)[1];

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
