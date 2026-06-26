<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Advise;
use App\Models\Article;
use App\Services\ContentSeoAiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FillContentSeoFields implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;

    public int $backoff = 15;

    public int $timeout = 180;

    public function __construct(
        public readonly string $modelClass,
        public readonly int $modelId,
    ) {}

    public function handle(ContentSeoAiService $contentSeoAiService): void
    {
        $model = $this->resolveModel();

        if ($model === null) {
            return;
        }

        if (! ContentSeoAiService::needsFill($model)) {
            Log::info('FillContentSeoFields: nothing to fill', [
                'model' => $this->modelClass,
                'id' => $this->modelId,
            ]);

            return;
        }

        $contentSeoAiService->fillMissingFields($model);
    }

    public function failed(\Throwable $e): void
    {
        Log::error('FillContentSeoFields: job failed', [
            'model' => $this->modelClass,
            'id' => $this->modelId,
            'error' => $e->getMessage(),
        ]);
    }

    private function resolveModel(): ?Model
    {
        return match ($this->modelClass) {
            Article::class => Article::query()->find($this->modelId),
            Advise::class => Advise::query()->find($this->modelId),
            default => null,
        };
    }
}
