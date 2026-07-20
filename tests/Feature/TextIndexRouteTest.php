<?php

namespace Tests\Feature;

use App\Models\Text;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TextIndexRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_text_index_returns_successful_response(): void
    {
        $response = $this->get('/text');

        $response->assertOk();
        $response->assertSee('Информация');
    }

    public function test_text_index_lists_active_pages(): void
    {
        Text::query()->create([
            'title' => 'Тестовая страница',
            'alias' => 'test-page',
            'description' => 'Описание',
            'content' => '<p>Контент</p>',
            'active' => 1,
        ]);

        Text::query()->create([
            'title' => 'Скрытая страница',
            'alias' => 'hidden-page',
            'description' => 'Описание',
            'content' => '<p>Контент</p>',
            'active' => 0,
        ]);

        $response = $this->get('/text');

        $response->assertOk();
        $response->assertSee('Тестовая страница');
        $response->assertDontSee('Скрытая страница');
    }

    public function test_text_show_renders_html_content(): void
    {
        Text::query()->create([
            'title' => 'Политика',
            'alias' => 'policy-test',
            'description' => 'Описание',
            'content' => '<p>Текст политики</p>',
            'active' => 1,
        ]);

        $response = $this->get('/text/policy-test');

        $response->assertOk();
        $response->assertSee('Политика');
        $response->assertSee('Текст политики', false);
    }
}
