<?php

namespace Tests\Unit;

use App\Services\TestCalculationService;
use Tests\TestCase;

class DisplayIbhbForResultsTest extends TestCase
{
    public function test_returns_stored_ibhb_when_no_recommendation_blocks(): void
    {
        $s = new TestCalculationService;
        $r = [
            'ibhb' => 61,
            'B' => [1 => 9, 2 => 9, 3 => 9, 4 => 9],
            'blocks' => [
                1 => ['paragraphs' => [], 'fields' => []],
                2 => ['paragraphs' => [], 'fields' => []],
                3 => ['paragraphs' => [], 'fields' => []],
                4 => ['paragraphs' => [], 'fields' => []],
            ],
        ];
        $this->assertSame(61, $s->displayIbhbForResults($r));
    }

    public function test_recalculates_ibhb_when_only_some_blocks_have_recommendations(): void
    {
        $s = new TestCalculationService;
        $r = [
            'ibhb' => 56,
            'B' => [1 => 10, 2 => 12, 3 => 5, 4 => 5],
            'blocks' => [
                1 => ['paragraphs' => ['<p>x</p>'], 'fields' => []],
                2 => ['paragraphs' => ['<p>y</p>'], 'fields' => []],
                3 => ['paragraphs' => [], 'fields' => []],
                4 => ['paragraphs' => [], 'fields' => []],
            ],
        ];
        // Svis = 22, Mvis = 18 + 24 → round(100 − 22/42·100) = 48 (отличается от ibhb по всем 72 баллам).
        $this->assertSame(48, $s->displayIbhbForResults($r));
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
