<?php

namespace App\Services;

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
}
