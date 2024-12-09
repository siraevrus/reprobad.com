<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\DataUriImageDecoder;
use Intervention\Image\Decoders\Base64ImageDecoder;

class ImageService
{
    public static function resize($input, $format = 'jpg'): string
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

        return $image->toDataUri();
    }
}
