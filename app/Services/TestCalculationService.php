<?php

namespace App\Services;

use App\Models\TestResultField;
use Illuminate\Support\Arr;

class TestCalculationService
{
    private const M = [1 => 18, 2 => 24, 3 => 15, 4 => 15];

    private const M_TOTAL = 72;

    /** Кодирования по блокам (порядок внутри блока) */
    private const BLOCK_CODINGS = [
        1 => [1, 2],
        2 => [3, 4, 5],
        3 => [6, 7],
        4 => [8, 9],
    ];

    /**
     * @param  array<int, int>  $answers  Индексы 0..23 — ответы q1..q24
     * @return array<string, mixed>
     */
    public function calculate(array $answers): array
    {
        if (count($answers) !== 24) {
            throw new \InvalidArgumentException('Должно быть ровно 24 ответа');
        }

        $a = array_map(static fn (int $v): int => max(0, min(3, $v)), array_map('intval', $answers));

        $B1 = $a[0] + $a[1] + $a[2] + $a[3] + $a[4] + $a[5];
        $B2 = $a[6] + $a[7] + $a[8] + $a[9] + $a[10] + $a[11] + $a[12] + $a[13];
        $B3 = $a[14] + $a[15] + $a[16] + $a[17] + $a[18];
        $B4 = $a[19] + $a[20] + $a[21] + $a[22] + $a[23];

        $B = [1 => $B1, 2 => $B2, 3 => $B3, 4 => $B4];
        $S = $B1 + $B2 + $B3 + $B4;

        $IDX = [
            1 => $this->idx($B1, self::M[1]),
            2 => $this->idx($B2, self::M[2]),
            3 => $this->idx($B3, self::M[3]),
            4 => $this->idx($B4, self::M[4]),
        ];

        $ibhb = (int) round(100 - ($S / self::M_TOTAL) * 100);

        $b1_36 = $a[2] + $a[3] + $a[4] + $a[5];

        $activeCodings = [];
        if ($a[0] + $a[1] >= 4) {
            $activeCodings[] = 1;
        }
        if ($b1_36 >= 6 && $b1_36 <= 8) {
            $activeCodings[] = 2;
        }
        if ($b1_36 >= 9) {
            $activeCodings[] = 3;
        }
        if ($B2 >= 15 && $B2 <= 20) {
            $activeCodings[] = 4;
        }
        if ($B2 >= 21) {
            $activeCodings[] = 5;
        }
        if ($B3 >= 8 && $B3 <= 11) {
            $activeCodings[] = 6;
        }
        if ($B3 >= 12) {
            $activeCodings[] = 7;
        }
        if ($B4 >= 8 && $B4 <= 12) {
            $activeCodings[] = 8;
        }
        if ($B4 >= 13) {
            $activeCodings[] = 9;
        }

        $hasCodings = $activeCodings !== [];

        $fieldsByNumber = TestResultField::query()
            ->active()
            ->whereIn('field_number', range(1, 9))
            ->orderBy('order')
            ->orderBy('field_number')
            ->get()
            ->keyBy('field_number');

        $items = [];
        foreach ($activeCodings as $num) {
            $f = $fieldsByNumber->get($num);
            if ($f) {
                $items[] = $this->serializeField($f);
            }
        }

        $blocks = [];
        foreach (self::BLOCK_CODINGS as $blockNum => $codings) {
            $blockFields = [];
            $paragraphs = [];
            foreach ($codings as $c) {
                if (! in_array($c, $activeCodings, true)) {
                    continue;
                }
                $f = $fieldsByNumber->get($c);
                if (! $f) {
                    continue;
                }
                $blockFields[] = $this->serializeField($f);
                $paragraphs[] = $this->fieldParagraphHtml($f);
            }

            $showPopup = false;
            foreach ($blockFields as $f) {
                if (trim((string) ($f['popup_html'] ?? '')) !== '' || ! empty($f['image1']) || ! empty($f['image2'])) {
                    $showPopup = true;
                    break;
                }
            }

            $blocks[$blockNum] = [
                'idx' => $IDX[$blockNum],
                'title' => (string) config('repro_test.block_titles.'.$blockNum, ''),
                'css' => config('repro_test.block_css.'.$blockNum, 'psih'),
                'paragraphs' => array_values(array_filter($paragraphs, static fn ($p) => $p !== '')),
                'fields' => $blockFields,
                'show_popup' => $showPopup,
            ];
        }

        return [
            'B' => $B,
            'S' => $S,
            'IDX' => $IDX,
            'ibhb' => $ibhb,
            'active_codings' => $activeCodings,
            'has_codings' => $hasCodings,
            'blocks' => $blocks,
            'items' => $items,
        ];
    }

    /**
     * «Зелёный» профиль ответов для копирайта на странице результата:
     * либо на каждый вопрос только 0 или 1 балл, либо одновременно:
     * вопросы 1–2 сумма ≤ 3, 3–6 < 6, 7–14 < 15, 15–19 < 8, 20–24 < 8 (индексы массива ответов 0..23).
     * При заполненных текстах в админке это совпадает с отсутствием срабатывания кодирований в calculate().
     *
     * @param  array<int, int|string>  $answers  Ровно 24 элемента — q1..q24
     */
    public function isExcellentScoreProfile(array $answers): bool
    {
        if (count($answers) !== 24) {
            return false;
        }

        $a = array_map(static fn ($v): int => max(0, min(3, (int) $v)), array_values($answers));

        $onlyZeroOrOne = true;
        foreach ($a as $v) {
            if ($v !== 0 && $v !== 1) {
                $onlyZeroOrOne = false;
                break;
            }
        }
        if ($onlyZeroOrOne) {
            return true;
        }

        $sum = static function (array $a, int $from, int $to): int {
            $s = 0;
            for ($i = $from; $i <= $to; $i++) {
                $s += $a[$i];
            }

            return $s;
        };

        return $sum($a, 0, 1) <= 3
            && $sum($a, 2, 5) < 6
            && $sum($a, 6, 13) < 15
            && $sum($a, 14, 18) < 8
            && $sum($a, 19, 23) < 8;
    }

    /**
     * Данные для страницы результата: тексты под шкалами берутся из актуальных записей test_result_fields,
     * а проценты (idx) и флаги расчёта — из сохранённого JSON (снимок на момент прохождения теста).
     * Так правки в админке видны без повторного прохождения теста.
     *
     * @param  array<string, mixed>  $storedResults
     * @return array<string, mixed>
     */
    public function resultsForView(array $storedResults): array
    {
        $r = $storedResults;
        $active = $r['active_codings'] ?? [];
        if (! is_array($active)) {
            $active = [];
        }
        // После JSON из БД номера могут быть строками; in_array(..., true) иначе не находит кодирование.
        $active = array_values(array_unique(array_map(static fn ($v): int => (int) $v, $active)));

        $live = TestResultField::query()
            ->active()
            ->whereIn('field_number', range(1, 9))
            ->orderBy('order')
            ->orderBy('field_number')
            ->get()
            ->keyBy('field_number');

        $IDX = is_array($r['IDX'] ?? null) ? $r['IDX'] : [];
        $prevBlocks = is_array($r['blocks'] ?? null) ? $r['blocks'] : [];
        $blocks = [];

        foreach (self::BLOCK_CODINGS as $blockNum => $codings) {
            $prev = [];
            if (isset($prevBlocks[$blockNum]) && is_array($prevBlocks[$blockNum])) {
                $prev = $prevBlocks[$blockNum];
            } elseif (isset($prevBlocks[(string) $blockNum]) && is_array($prevBlocks[(string) $blockNum])) {
                $prev = $prevBlocks[(string) $blockNum];
            }
            $idx = (int) ($prev['idx'] ?? $IDX[$blockNum] ?? $IDX[(string) $blockNum] ?? 0);

            $blockFields = [];
            $paragraphs = [];

            foreach ($codings as $c) {
                if (! in_array($c, $active, true)) {
                    continue;
                }
                $model = $live->get($c);
                if (! $model) {
                    continue;
                }
                $blockFields[] = $this->serializeField($model);
                $paragraphs[] = $this->fieldParagraphHtml($model);
            }

            $showPopup = false;
            foreach ($blockFields as $f) {
                if (trim((string) ($f['popup_html'] ?? '')) !== '' || ! empty($f['image1']) || ! empty($f['image2'])) {
                    $showPopup = true;
                    break;
                }
            }

            $blocks[$blockNum] = [
                'idx' => $idx,
                'title' => (string) ($prev['title'] ?? config('repro_test.block_titles.'.$blockNum, '')),
                'css' => config('repro_test.block_css.'.$blockNum, 'psih'),
                'paragraphs' => array_values(array_filter($paragraphs, static fn ($p) => $p !== '')),
                'fields' => $blockFields,
                'show_popup' => $showPopup,
            ];
        }

        $r['blocks'] = $blocks;

        $items = [];
        foreach ($active as $num) {
            $model = $live->get($num);
            if ($model) {
                $items[] = $this->serializeField($model);
            }
        }
        $r['items'] = $items;

        return $r;
    }

    /**
     * ИБГБ для отображения (страница и письмо): если есть блоки с персональными рекомендациями —
     * считаем 100 − (сумма набранных по этим блокам / сумма их максимумов)·100, как на сайте.
     * Иначе — сохранённое значение из расчёта по всем 72 макс. баллам теста.
     *
     * @param  array<string, mixed>  $r  Данные после {@see resultsForView()} или сырой JSON результатов.
     */
    public function displayIbhbForResults(array $r): int
    {
        $ibhbStored = (int) ($r['ibhb'] ?? 0);
        $flags = $this->blocksWithRecommendationContent($r);
        if (! in_array(true, $flags, true)) {
            return $ibhbStored;
        }

        $blockMaxSum = (array) (config('repro_test.block_max_sum') ?? []);
        $B = isset($r['B']) && is_array($r['B']) ? $r['B'] : [];
        $Svis = 0;
        $Mvis = 0;
        for ($i = 1; $i <= 4; $i++) {
            if (empty($flags[$i])) {
                continue;
            }
            $Svis += (int) Arr::get($B, $i, Arr::get($B, (string) $i, 0));
            $Mvis += (int) ($blockMaxSum[$i] ?? 0);
        }

        return $Mvis > 0 ? (int) round(100 - ($Svis / $Mvis) * 100) : $ibhbStored;
    }

    /**
     * Блоки, для которых на странице показываются рекомендации (тот же критерий, что в result.blade.php).
     *
     * @param  array<string, mixed>  $r
     * @return array<int, bool>
     */
    public function blocksWithRecommendationContent(array $r): array
    {
        $blockHasContent = [];
        for ($i = 1; $i <= 4; $i++) {
            $blk = Arr::get($r, 'blocks.'.$i, []);
            $blk = is_array($blk) ? $blk : [];
            $paragraphs = isset($blk['paragraphs']) && is_array($blk['paragraphs']) ? $blk['paragraphs'] : [];
            $fields = isset($blk['fields']) && is_array($blk['fields']) ? $blk['fields'] : [];
            $has = count($paragraphs) > 0;
            if (! $has && count($fields) > 0) {
                foreach ($fields as $fld) {
                    $pd = trim((string) ($fld['description'] ?? ''));
                    $pe = trim((string) ($fld['email_description'] ?? ''));
                    if ($pd !== '' || $pe !== '') {
                        $has = true;
                        break;
                    }
                }
            }
            $blockHasContent[$i] = $has;
        }

        return $blockHasContent;
    }

    /**
     * По одной случайной фразе на блок (для экрана/письма без кодирований).
     *
     * @return array<int, string> ключи 1..4
     */
    public function pickRandomAllClearPhrases(): array
    {
        $picked = [];
        for ($i = 1; $i <= 4; $i++) {
            $phrases = config("repro_test.block_all_clear_phrases.$i", []);
            if (! is_array($phrases)) {
                $phrases = [];
            }
            $phrases = array_values(array_filter($phrases, static fn ($p): bool => trim((string) $p) !== ''));
            if ($phrases === []) {
                $picked[$i] = '';

                continue;
            }
            $picked[$i] = $phrases[random_int(0, count($phrases) - 1)];
        }

        return $picked;
    }

    private function idx(int $Bk, int $Mk): int
    {
        return (int) round(100 - ($Bk / $Mk) * 100);
    }

    /**
     * Текст под полоской прогресса: основное описание поля, при пустом — расширенное для email.
     */
    private function fieldParagraphHtml(TestResultField $f): string
    {
        $primary = trim((string) ($f->description ?? ''));
        if ($primary !== '') {
            return $primary;
        }

        return trim((string) ($f->email_description ?? ''));
    }

    /**
     * @return array<string, mixed>
     */
    private function serializeField(TestResultField $f): array
    {
        return [
            'field_number' => $f->field_number,
            'description' => $f->description,
            'email_description' => $f->email_description ?? $f->description,
            'popup_html' => $f->popup_html ?? '',
            'color' => $f->color,
            'image1' => $f->image1,
            'link1' => $f->link1,
            'image2' => $f->image2,
            'link2' => $f->link2,
        ];
    }
}
