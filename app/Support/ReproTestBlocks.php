<?php

namespace App\Support;

/**
 * Четыре блока теста (совпадают с суммами вопросов в TestCalculationService и config/repro_test.block_titles).
 */
final class ReproTestBlocks
{
    /**
     * @return array<int, string> номер блока 1–4 => заголовок
     */
    public static function titles(): array
    {
        $t = (array) config('repro_test.block_titles', []);

        return [
            1 => (string) ($t[1] ?? ''),
            2 => (string) ($t[2] ?? ''),
            3 => (string) ($t[3] ?? ''),
            4 => (string) ($t[4] ?? ''),
        ];
    }

    /** Блок по номеру вопроса в тесте (1–24), как в расчёте B1…B4. */
    public static function blockForQuestionOrder(int $order): int
    {
        return match (true) {
            $order >= 1 && $order <= 6 => 1,
            $order >= 7 && $order <= 14 => 2,
            $order >= 15 && $order <= 19 => 3,
            $order >= 20 && $order <= 24 => 4,
            default => throw new \InvalidArgumentException('order must be 1-24'),
        };
    }

    /** Блок по номеру кодирования (поле результата 1–9), из config repro_test.coding_to_block. */
    public static function blockForFieldNumber(int $fieldNumber): ?int
    {
        $map = (array) config('repro_test.coding_to_block', []);

        return isset($map[$fieldNumber]) ? (int) $map[$fieldNumber] : null;
    }
}
