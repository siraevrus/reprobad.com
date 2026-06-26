<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Concerns;

use App\Services\CleanWordHtmlService;

trait SanitizesRichTextFields
{
    /** @param callable(string): string|null $contentPostProcessor */
    protected function sanitizeRichTextFields(array $data, ?callable $contentPostProcessor = null): array
    {
        $cleaner = app(CleanWordHtmlService::class);

        if (array_key_exists('content', $data)) {
            $content = $cleaner->clean($data['content'] ?? '');
            if ($contentPostProcessor !== null) {
                $content = $contentPostProcessor($content);
            }
            $data['content'] = $content;
        }

        if (array_key_exists('description', $data)) {
            $data['description'] = $cleaner->clean($data['description'] ?? '');
        }

        return $data;
    }
}
