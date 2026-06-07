<?php

namespace App\Console\Commands;

use App\Models\Advise;
use App\Services\InternalLinkService;
use Illuminate\Console\Command;

class ApplyAdviseInternalLinks extends Command
{
    protected $signature = 'advises:apply-internal-links
                            {file : Path to the xlsx spreadsheet}
                            {--dry-run : Report changes without saving}';

    protected $description = 'Insert internal advise links from spreadsheet into advise content';

    public function handle(InternalLinkService $linkService): int
    {
        $file = $this->argument('file');
        $dryRun = (bool) $this->option('dry-run');

        if (! is_file($file)) {
            $this->error("File not found: {$file}");

            return self::FAILURE;
        }

        $rows = $linkService->parseSpreadsheet($file);
        $this->info('Rows in spreadsheet: ' . count($rows));

        $advises = Advise::query()->get()->keyBy(fn (Advise $advise): string => $this->normalizeTitle($advise->title));
        $grouped = [];
        foreach ($rows as [$title, $phrase, $url]) {
            $grouped[$this->normalizeTitle($title)][] = [$phrase, $url];
        }

        $stats = [
            'linked' => 0,
            'already_linked' => 0,
            'not_found' => 0,
            'missing_advise' => 0,
            'updated_advises' => 0,
        ];
        $notFoundRows = [];
        $missingAdvises = [];

        foreach ($grouped as $title => $links) {
            if (! isset($advises[$title])) {
                $stats['missing_advise'] += count($links);
                $missingAdvises[$title] = count($links);
                continue;
            }

            usort($links, static fn (array $left, array $right): int => mb_strlen($right[0]) <=> mb_strlen($left[0]));

            /** @var Advise $advise */
            $advise = $advises[$title];
            $content = $advise->content ?? '';
            $adviseChanged = false;

            foreach ($links as [$phrase, $url]) {
                $result = $linkService->insertLink($content, $phrase, $url);
                $content = $result['html'];
                $stats[$result['status']]++;

                if ($result['status'] === 'not_found') {
                    $notFoundRows[] = [$title, $phrase, $url];
                }

                if ($result['status'] === 'linked') {
                    $adviseChanged = true;
                }
            }

            if ($adviseChanged) {
                $stats['updated_advises']++;
                if (! $dryRun) {
                    $advise->content = $content;
                    $advise->save();
                }
            }
        }

        $this->newLine();
        $this->info('Results:');
        $this->line("  Linked: {$stats['linked']}");
        $this->line("  Already linked: {$stats['already_linked']}");
        $this->line("  Phrase not found: {$stats['not_found']}");
        $this->line("  Missing advise: {$stats['missing_advise']}");
        $this->line('  Advises updated: ' . $stats['updated_advises'] . ($dryRun ? ' (dry-run)' : ''));

        if ($missingAdvises !== []) {
            $this->newLine();
            $this->warn('Advises not found in database:');
            foreach ($missingAdvises as $title => $count) {
                $this->line("  - {$title} ({$count} links)");
            }
        }

        if ($notFoundRows !== []) {
            $this->newLine();
            $this->warn('Phrases not found in content:');
            foreach ($notFoundRows as [$title, $phrase, $url]) {
                $this->line("  - [{$title}] \"{$phrase}\" -> {$url}");
            }
        }

        if ($dryRun && $stats['linked'] > 0) {
            $this->newLine();
            $this->comment('Dry-run complete. Re-run without --dry-run to apply changes.');
        }

        return $stats['missing_advise'] > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function normalizeTitle(string $title): string
    {
        return preg_replace('/[\s\x{00A0}]+/u', ' ', trim($title)) ?? trim($title);
    }
}
