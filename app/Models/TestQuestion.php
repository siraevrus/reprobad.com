<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    protected $table = 'test_questions';

    protected $guarded = ['id'];

    protected $casts = [
        'answers' => 'array',
        'active' => 'boolean',
        'block_number' => 'integer',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order', 'asc');
    }

    /**
     * Варианты ответов, отсортированные по баллу по возрастанию (0,1,2,3).
     * Гарантирует, что на форме теста и в админке вариант с меньшим баллом всегда показывается первым.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getSortedAnswersAttribute(): array
    {
        $answers = $this->answers;
        if (! is_array($answers)) {
            return [];
        }

        $sorted = array_values($answers);
        usort($sorted, static function ($a, $b): int {
            $av = (int) ($a['value'] ?? 0);
            $bv = (int) ($b['value'] ?? 0);

            return $av <=> $bv;
        });

        return $sorted;
    }

    /**
     * Привести массив ответов к каноническому виду: отсортировать по value ASC и обрезать value до 0..3.
     * Используется при сохранении в админке, чтобы JSON в БД хранился уже в нужном порядке.
     *
     * @param  array<int, array<string, mixed>>  $answers
     * @return array<int, array<string, mixed>>
     */
    public static function normalizeAnswers(array $answers): array
    {
        $normalized = [];
        foreach ($answers as $a) {
            if (! is_array($a)) {
                continue;
            }
            $normalized[] = [
                'text' => (string) ($a['text'] ?? ''),
                'value' => max(0, min(3, (int) ($a['value'] ?? 0))),
            ];
        }

        usort($normalized, static fn (array $a, array $b): int => $a['value'] <=> $b['value']);

        return array_values($normalized);
    }
}
