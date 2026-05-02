<?php

namespace Tests\Unit;

use App\Services\TestCalculationService;
use PHPUnit\Framework\TestCase;

class TestExcellentScoreProfileTest extends TestCase
{
    public function test_all_zero_or_one_is_excellent(): void
    {
        $s = new TestCalculationService;
        $this->assertTrue($s->isExcellentScoreProfile(array_fill(0, 24, 0)));
        $this->assertTrue($s->isExcellentScoreProfile(array_fill(0, 24, 1)));
    }

    public function test_bracket_thresholds_example_is_excellent(): void
    {
        $s = new TestCalculationService;
        // 1+2=3, вопросы 3–6 сумма 5, 7–14 сумма 14, 15–19 сумма 7, 20–24 сумма 7
        $a = array_merge(
            [2, 1, 1, 1, 1, 1],
            array_fill(6, 8, 1),
            array_fill(14, 5, 1),
            array_fill(19, 5, 1)
        );
        $this->assertCount(24, $a);
        $this->assertTrue($s->isExcellentScoreProfile($a));
    }

    public function test_wrong_count_returns_false(): void
    {
        $s = new TestCalculationService;
        $this->assertFalse($s->isExcellentScoreProfile([]));
        $this->assertFalse($s->isExcellentScoreProfile(array_fill(0, 23, 0)));
    }

    public function test_not_excellent_when_all_twos(): void
    {
        $s = new TestCalculationService;
        $this->assertFalse($s->isExcellentScoreProfile(array_fill(0, 24, 2)));
    }
}
