<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\DataUriImageDecoder;
use Intervention\Image\Decoders\Base64ImageDecoder;

class ImageService
{
    public static function resize($input, $format = 'jpg', $path = ''): string
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

    function upload($input, $path): bool|string
    {
        return Storage::disk('public')->put($path, $input);
    }
}
