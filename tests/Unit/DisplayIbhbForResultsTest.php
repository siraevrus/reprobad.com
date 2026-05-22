<?php

namespace Tests\Unit;

use App\Services\TestCalculationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisplayIbhbForResultsTest extends TestCase
{
    use RefreshDatabase;
    public function test_display_ibhb_is_average_of_four_block_idx(): void
    {
        $s = new TestCalculationService;
        $r = [
            'ibhb' => 61,
            'IDX' => [1 => 50, 2 => 63, 3 => 40, 4 => 40],
            'B' => [1 => 9, 2 => 9, 3 => 9, 4 => 9],
            'blocks' => [
                1 => ['paragraphs' => [], 'fields' => []],
                2 => ['paragraphs' => [], 'fields' => []],
                3 => ['paragraphs' => [], 'fields' => []],
                4 => ['paragraphs' => [], 'fields' => []],
            ],
        ];
        // (50 + 63 + 40 + 40) / 4 = 48.25 → 48
        $this->assertSame(48, $s->displayIbhbForResults($r));
    }

    public function test_display_ibhb_ignores_stored_ibhb_when_idx_present(): void
    {
        $s = new TestCalculationService;
        $r = [
            'ibhb' => 56,
            'IDX' => [1 => 44, 2 => 50, 3 => 67, 4 => 67],
            'B' => [1 => 10, 2 => 12, 3 => 5, 4 => 5],
            'blocks' => [
                1 => ['paragraphs' => ['<p>x</p>'], 'fields' => []],
                2 => ['paragraphs' => ['<p>y</p>'], 'fields' => []],
                3 => ['paragraphs' => [], 'fields' => []],
                4 => ['paragraphs' => [], 'fields' => []],
            ],
        ];
        // (44 + 50 + 67 + 67) / 4 = 57
        $this->assertSame(57, $s->displayIbhbForResults($r));
    }

    public function test_display_ibhb_recomputes_from_b_when_idx_missing(): void
    {
        $s = new TestCalculationService;
        $r = [
            'ibhb' => 99,
            'B' => [1 => 10, 2 => 12, 3 => 5, 4 => 5],
        ];
        $this->assertSame(57, $s->displayIbhbForResults($r));
    }

    public function test_calculate_stores_ibhb_as_average_of_block_idx(): void
    {
        $s = new TestCalculationService;
        $answers = array_fill(0, 24, 1);
        $result = $s->calculate($answers);

        $expected = (int) round(
            ($result['IDX'][1] + $result['IDX'][2] + $result['IDX'][3] + $result['IDX'][4]) / 4
        );
        $this->assertSame($expected, $result['ibhb']);
    }

    public function test_pick_random_all_clear_phrases_returns_one_non_empty_line_per_block(): void
    {
        $s = new TestCalculationService;
        $p = $s->pickRandomAllClearPhrases();
        $this->assertCount(4, $p);
        foreach ([1, 2, 3, 4] as $i) {
            $this->assertArrayHasKey($i, $p);
            $this->assertNotSame('', trim($p[$i]));
        }
    }
}
