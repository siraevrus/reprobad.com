<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class DataUriImageMaterializer
{
    /**
     * Save a data-URI image into public disk and return a web path like /storage/advises/image_12.jpg.
     */
    public function materialize(string $dataUri, string $folder, int $id): ?string
    {
        $dataUri = trim($dataUri);
        if (! str_starts_with($dataUri, 'data:')) {
            return null;
        }

        if (! preg_match('#^data:image/(png|jpe?g|gif|webp|svg\+xml);base64,(.+)$#is', $dataUri, $matches)) {
            return null;
        }

        $type = strtolower($matches[1]);
        $binary = base64_decode($matches[2], true);
        if ($binary === false || $binary === '') {
            return null;
        }

        $ext = match ($type) {
            'jpeg', 'jpg' => 'jpg',
            'svg+xml' => 'svg',
            default => $type,
        };

        $relative = trim($folder, '/') . '/image_' . $id . '.' . $ext;
        Storage::disk('public')->put($relative, $binary);

        return '/storage/' . $relative;
    }
}
