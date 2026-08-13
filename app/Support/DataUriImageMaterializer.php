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
        $stored = $this->storeHashed($dataUri, $folder);
        if ($stored !== null) {
            return $stored;
        }

        return $this->storeNamed($dataUri, $folder, 'image_'.$id);
    }

    /**
     * Save a data-URI image under a content-hash filename so identical payloads are stored once.
     */
    public function storeHashed(string $dataUri, string $folder = 'pages'): ?string
    {
        $parsed = $this->decode($dataUri);
        if ($parsed === null) {
            return null;
        }

        [$ext, $binary] = $parsed;
        $relative = trim($folder, '/').'/'.hash('sha256', $binary).'.'.$ext;
        Storage::disk('public')->put($relative, $binary);

        return '/storage/'.$relative;
    }

    /**
     * Recursively replace data:image URIs in CMS JSON (pages.content) with public storage paths.
     *
     * @param  mixed  $value
     * @return array{0: mixed, 1: bool} [value, changed]
     */
    public function replaceDataUrisInTree(mixed $value, string $folder = 'pages'): array
    {
        $changed = false;

        if (is_string($value) && str_starts_with(trim($value), 'data:image/')) {
            $stored = $this->storeHashed($value, $folder);

            return $stored === null ? [$value, false] : [$stored, true];
        }

        if (is_array($value)) {
            foreach ($value as $key => $item) {
                [$replaced, $itemChanged] = $this->replaceDataUrisInTree($item, $folder);
                if ($itemChanged) {
                    $value[$key] = $replaced;
                    $changed = true;
                }
            }
        }

        return [$value, $changed];
    }

    private function storeNamed(string $dataUri, string $folder, string $basename): ?string
    {
        $parsed = $this->decode($dataUri);
        if ($parsed === null) {
            return null;
        }

        [$ext, $binary] = $parsed;
        $relative = trim($folder, '/').'/'.$basename.'.'.$ext;
        Storage::disk('public')->put($relative, $binary);

        return '/storage/'.$relative;
    }

    /**
     * @return array{0: string, 1: string}|null [extension, binary]
     */
    private function decode(string $dataUri): ?array
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

        return [$ext, $binary];
    }
}
