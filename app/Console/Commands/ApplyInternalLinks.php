<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Services\InternalLinkService;
use Illuminate\Console\Command;

class ApplyInternalLinks extends Command
{
    protected $signature = 'articles:apply-internal-links
                            {file : Path to the xlsx spreadsheet}
                            {--dry-run : Report changes without saving}';

    protected $description = 'Insert internal article links from spreadsheet into article content';

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

        $articles = Article::query()->get()->keyBy('title');
        $grouped = [];
        foreach ($rows as [$title, $phrase, $url]) {
            $grouped[$title][] = [$phrase, $url];
        }

        $stats = [
            'linked' => 0,
            'already_linked' => 0,
            'not_found' => 0,
            'missing_article' => 0,
            'updated_articles' => 0,
        ];
        $notFoundRows = [];
        $missingArticles = [];

        foreach ($grouped as $title => $links) {
            if (! isset($articles[$title])) {
                $stats['missing_article'] += count($links);
                $missingArticles[$title] = count($links);
                continue;
            }

            usort($links, static fn (array $left, array $right): int => mb_strlen($right[0]) <=> mb_strlen($left[0]));

            /** @var Article $article */
            $article = $articles[$title];
            $content = $article->content;
            $articleChanged = false;

            foreach ($links as [$phrase, $url]) {
                $result = $linkService->insertLink($content, $phrase, $url);
                $content = $result['html'];
                $stats[$result['status']]++;

                if ($result['status'] === 'not_found') {
                    $notFoundRows[] = [$title, $phrase, $url];
                }

                if ($result['status'] === 'linked') {
                    $articleChanged = true;
                }
            }

            if ($articleChanged) {
                $stats['updated_articles']++;
                if (! $dryRun) {
                    $article->content = $content;
                    $article->save();
                }
            }
        }

        $this->newLine();
        $this->info('Results:');
        $this->line("  Linked: {$stats['linked']}");
        $this->line("  Already linked: {$stats['already_linked']}");
        $this->line("  Phrase not found: {$stats['not_found']}");
        $this->line("  Missing article: {$stats['missing_article']}");
        $this->line('  Articles updated: ' . $stats['updated_articles'] . ($dryRun ? ' (dry-run)' : ''));

        if ($missingArticles !== []) {
            $this->newLine();
            $this->warn('Articles not found in database:');
            foreach ($missingArticles as $title => $count) {
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

        return $stats['missing_article'] > 0 ? self::FAILURE : self::SUCCESS;
    }
}
