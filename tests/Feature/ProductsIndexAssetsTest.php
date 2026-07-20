<?php

namespace Tests\Feature;

use App\Models\Complex;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsIndexAssetsTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_does_not_emit_hex_color_stylesheet(): void
    {
        $complex = Complex::query()->create([
            'title' => 'Комплекс',
            'alias' => 'test-complex',
            'active' => 1,
            'color' => 'purple',
        ]);

        Product::query()->create([
            'title' => 'Продукт',
            'alias' => 'test-product',
            'description' => 'Описание',
            'active' => 1,
            'sort' => 1,
            'color' => '#7268a5',
            'complex_id' => $complex->id,
            'logo' => '/images/logo.png',
            'image' => '/images/product.png',
        ]);

        $response = $this->get('/products');

        $response->assertOk();
        $response->assertDontSee('css/#7268a5.css', false);
        $response->assertDontSee('/css/#', false);
    }
}
