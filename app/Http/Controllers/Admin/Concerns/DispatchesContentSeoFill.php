<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Concerns;

use App\Jobs\FillContentSeoFields;
use App\Services\ContentSeoAiService;
use Illuminate\Database\Eloquent\Model;

trait DispatchesContentSeoFill
{
    protected function dispatchContentSeoFillIfNeeded(Model $resource): bool
    {
        if (! ContentSeoAiService::needsFill($resource)) {
            return false;
        }

        FillContentSeoFields::dispatch($resource::class, (int) $resource->getKey());

        return true;
    }

    /** @param array<string, mixed> $payload */
    protected function withSeoAiQueuedFlag(array $payload, Model $resource): array
    {
        $payload['seo_ai_queued'] = $this->dispatchContentSeoFillIfNeeded($resource);

        return $payload;
    }
}
