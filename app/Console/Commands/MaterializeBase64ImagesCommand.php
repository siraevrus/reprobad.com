<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Advise;
use App\Models\Article;
use App\Support\DataUriImageMaterializer;
use Illuminate\Console\Command;

class MaterializeBase64ImagesCommand extends Command
{
    protected $signature = 'images:materialize-base64
                            {--dry-run : Show what would change without writing files}';

    protected $description = 'Convert base64 data-URI images in articles/advises into public storage files';

    public function handle(DataUriImageMaterializer $materializer): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $converted = 0;
        $skipped = 0;

        foreach ([Article::class => 'articles', Advise::class => 'advises'] as $modelClass => $folder) {
            $this->info("Processing {$folder}...");

            $modelClass::query()
                ->orderBy('id')
                ->each(function ($model) use ($materializer, $folder, $dryRun, &$converted, &$skipped) {
                    $image = trim((string) ($model->image ?? ''));
                    if ($image === '' || ! str_starts_with($image, 'data:')) {
                        $skipped++;

                        return;
                    }

                    if ($dryRun) {
                        $this->line("  [dry-run] {$folder}#{$model->id} {$model->alias}");
                        $converted++;

                        return;
                    }

                    $path = $materializer->materialize($image, $folder, (int) $model->id);
                    if ($path === null) {
                        $this->warn("  failed {$folder}#{$model->id}");

                        return;
                    }

                    $model->image = $path;
                    $model->save();
                    $this->line("  {$folder}#{$model->id} -> {$path}");
                    $converted++;
                });
        }

        $this->info("Converted: {$converted}, skipped: {$skipped}");

        return self::SUCCESS;
    }
}
