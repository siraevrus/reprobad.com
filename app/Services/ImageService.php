<?php

namespace App\Services;

use App\Models\Complex;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\DataUriImageDecoder;
use Intervention\Image\Decoders\Base64ImageDecoder;

class ImageService
{
    /**
     * Resize images by intervention package
     *
     * @param string $input
     * @param string $format
     * @param string $path
     * @return string
     */
    public static function resize(string $input, string $format = 'jpg', string $path = ''): string
    {
        $manager = new ImageManager(new Driver());

        $image = $manager->read($input, [
            DataUriImageDecoder::class,
            Base64ImageDecoder::class,
        ]);

        $image->scale(width: 1200);

        switch($format) {
            case 'jpg':
                $image = $image->toJpeg();
                break;
            case 'png':
                $image = $image->toPng();
                break;
        }

        if($path) {
            $fileName = uniqid('image_') . '.' . $format;
            $directory = storage_path('app/public/' . $path);

            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $filePath = $directory . '/' . $fileName;
            $image->save($filePath);
            return "/storage/$path/$fileName";
        }
        return $image->toDataUri();
    }

    /**
     * @param $input
     * @param string $path
     * @return bool|string
     */
    function upload($input, string $path): bool|string
    {
        return Storage::disk('public')->put($path, $input);
    }

    /**
     * Upload gallery
     *
     * @param array $images
     * @param $resource
     * @param string $field
     * @return bool
     */
    public static function uploadGallery(array $images, $resource, $field = 'images'): bool
    {
        foreach ($images as $key => $image) {
            if(isset($image['remove']) && $image['remove'] === true) {
                Storage::disk('public')->delete($image['url']);
                unset($images[$key]);
                continue;
            }
            if(!str_contains($image['url'], 'data:')) continue;
            $path = self::resize($image['url'], 'png', 'complex/' . $resource->id);
            $images[$key]['url'] = $path;
        }
        $resource->$field = $images;
        $resource->save();

        return true;
    }
}
