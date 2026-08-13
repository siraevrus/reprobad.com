<?php

namespace Tests\Unit;

use App\Models\Complex;
use App\Models\Product;
use App\Support\DietarySupplementJsonLd;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DietarySupplementJsonLdNameTest extends TestCase
{
    public function test_resolves_commercial_name_from_title_markers(): void
    {
        $complex = new Complex(['alias' => 'other', 'title' => 'X']);
        $product = new Product(['title' => 'РепроГеном', 'alias' => 'genom']);

        $this->assertSame(
            'РЕПРОГЕНОМ',
            DietarySupplementJsonLd::resolveName($product, $complex)
        );
    }

    public function test_falls_back_to_complex_slot_when_title_is_a_stage_name(): void
    {
        $complex = new Complex(['alias' => 'reprorelax', 'title' => 'Стресс']);
        $first = new Product(['title' => 'Психо-эмоциональное равновесие', 'alias' => 'a']);
        $second = new Product([
            'title' => 'Компоненты комплекса способствуют повышению устойчивости к стрессу',
            'alias' => 'b',
        ]);

        $this->assertSame(
            'РЕПРОРЕЛАКС ГИПЕРКОРТИЗОЛ',
            DietarySupplementJsonLd::resolveName($first, $complex, 0)
        );
        $this->assertSame(
            'РЕПРОРЕЛАКС ГИПОКОРТИЗОЛ',
            DietarySupplementJsonLd::resolveName($second, $complex, 1)
        );
    }

    #[DataProvider('complexSlots')]
    public function test_slot_map_covers_all_complexes(string $alias, int $slot, string $expected): void
    {
        $complex = new Complex(['alias' => $alias, 'title' => $alias]);
        $product = new Product(['title' => 'Очищение организма', 'alias' => 'slot-'.$slot]);

        $this->assertSame(
            $expected,
            DietarySupplementJsonLd::resolveName($product, $complex, $slot)
        );
    }

    public static function complexSlots(): array
    {
        return [
            ['reprorelax', 0, 'РЕПРОРЕЛАКС ГИПЕРКОРТИЗОЛ'],
            ['reprorelax', 1, 'РЕПРОРЕЛАКС ГИПОКОРТИЗОЛ'],
            ['repro-detoxi-biom', 0, 'РЕПРОДЕТОКСИ'],
            ['repro-detoxi-biom', 1, 'РЕПРОБИОМ'],
            ['repro-metabo-energy', 0, 'РЕПРОМЕТАБО'],
            ['repro-metabo-energy', 1, 'РЕПРОЭНЕРДЖИ'],
            ['repro-embrio-genom', 0, 'РЕПРОЭМБРИО'],
            ['repro-embrio-genom', 1, 'РЕПРОГЕНОМ'],
        ];
    }
}
