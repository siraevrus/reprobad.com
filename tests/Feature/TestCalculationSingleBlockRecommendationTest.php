<?php

namespace Tests\Feature;

use App\Models\TestResultField;
use App\Services\TestCalculationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestCalculationSingleBlockRecommendationTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_result_block_has_at_most_one_field_when_multiple_codings_fire(): void
    {
        for ($i = 1; $i <= 9; $i++) {
            TestResultField::query()->create([
                'field_number' => $i,
                'description' => '<p>Кодирование '.$i.'</p>',
                'email_description' => null,
                'color' => null,
                'image1' => null,
                'link1' => null,
                'image2' => null,
                'link2' => null,
                'popup_html' => null,
                'active' => true,
                'order' => $i,
                'block_number' => match (true) {
                    $i <= 2 => 1,
                    $i <= 5 => 2,
                    $i <= 7 => 3,
                    default => 4,
                },
            ]);
        }

        $answers = array_fill(0, 24, 3);
        $calc = app(TestCalculationService::class);
        $result = $calc->calculate($answers);

        foreach ([1, 2, 3, 4] as $bn) {
            $block = $result['blocks'][$bn];
            $fields = $block['fields'] ?? [];
            $paragraphs = $block['paragraphs'] ?? [];
            $this->assertLessThanOrEqual(
                1,
                count($fields),
                "Блок {$bn}: ожидается не больше одного поля рекомендации"
            );
            $this->assertLessThanOrEqual(
                1,
                count($paragraphs),
                "Блок {$bn}: ожидается не больше одного абзаца"
            );
        }

        // Блок 2: при всех «3» срабатывают кодирования 3 и 5 — на выводе только последнее (5).
        $this->assertCount(1, $result['blocks'][2]['fields']);
        $this->assertSame(5, (int) ($result['blocks'][2]['fields'][0]['field_number'] ?? 0));

        $view = $calc->resultsForView($result);
        $this->assertCount(1, $view['blocks'][2]['fields']);
        $this->assertSame(5, (int) ($view['blocks'][2]['fields'][0]['field_number'] ?? 0));
    }
}
