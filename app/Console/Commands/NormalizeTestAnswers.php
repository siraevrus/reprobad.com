<?php

namespace App\Console\Commands;

use App\Models\TestQuestion;
use Illuminate\Console\Command;

class NormalizeTestAnswers extends Command
{
    /** @var string */
    protected $signature = 'test:normalize-answers
        {--dry-run : Только показать, что бы изменилось, без записи в БД}';

    /** @var string */
    protected $description = 'Привести варианты ответов всех TestQuestion к каноническому виду (отсортировать по баллу 0..3) и сообщить про дубликаты/пропуски значений.';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');

        $questions = TestQuestion::query()->orderBy('order')->get();
        if ($questions->isEmpty()) {
            $this->warn('В БД нет вопросов теста.');

            return Command::SUCCESS;
        }

        $sorted = 0;
        $alreadyOk = 0;
        $withDuplicates = [];
        $withMissingValues = [];

        foreach ($questions as $q) {
            $answers = is_array($q->answers) ? $q->answers : [];

            $values = array_map(static fn ($a): int => (int) ($a['value'] ?? 0), $answers);
            $unique = array_unique($values);
            if (count($unique) !== count($values)) {
                $withDuplicates[] = sprintf('order=%d (#%d): значения [%s]', (int) $q->order, $q->id, implode(', ', $values));
            }
            $missing = array_values(array_diff([0, 1, 2, 3], $unique));
            if ($missing !== []) {
                $withMissingValues[] = sprintf('order=%d (#%d): отсутствуют значения [%s]', (int) $q->order, $q->id, implode(', ', $missing));
            }

            $normalized = TestQuestion::normalizeAnswers($answers);
            $wasInOrder = $this->sequencesEqual($answers, $normalized);

            if ($wasInOrder) {
                $alreadyOk++;

                continue;
            }

            $sorted++;
            $this->line(sprintf('• order=%d → пересортировано (#%d)', (int) $q->order, $q->id));

            if (! $dry) {
                $q->answers = $normalized;
                $q->save();
            }
        }

        $this->newLine();
        $this->info(sprintf('Уже в порядке: %d', $alreadyOk));
        $this->info(sprintf('Пересортировано: %d%s', $sorted, $dry ? ' (dry-run, ничего не сохранено)' : ''));

        if ($withDuplicates !== []) {
            $this->warn('Найдены вопросы с дублирующимися баллами:');
            foreach ($withDuplicates as $line) {
                $this->warn('  '.$line);
            }
        }
        if ($withMissingValues !== []) {
            $this->warn('Найдены вопросы с пропущенными значениями 0..3:');
            foreach ($withMissingValues as $line) {
                $this->warn('  '.$line);
            }
            $this->warn('Эти вопросы при сохранении из админки не пройдут валидацию (баллы должны быть уникальны 0..3).');
        }

        return Command::SUCCESS;
    }

    /**
     * @param  array<int, array<string, mixed>>  $a
     * @param  array<int, array<string, mixed>>  $b
     */
    private function sequencesEqual(array $a, array $b): bool
    {
        if (count($a) !== count($b)) {
            return false;
        }

        $a = array_values($a);
        $b = array_values($b);
        foreach ($a as $i => $row) {
            $av = (int) ($row['value'] ?? 0);
            $bv = (int) ($b[$i]['value'] ?? 0);
            $at = (string) ($row['text'] ?? '');
            $bt = (string) ($b[$i]['text'] ?? '');
            if ($av !== $bv || $at !== $bt) {
                return false;
            }
        }

        return true;
    }
}
