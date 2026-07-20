<?php

namespace Tests\Feature;

use App\Models\Advise;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class RssFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_rss_feed_returns_articles_and_advises(): void
    {
        Cache::forget('feeds.rss');

        $article = Article::query()->create([
            'title' => 'RSS Test Article '.uniqid(),
            'alias' => 'rss-test-article-'.uniqid(),
            'description' => '<p>Краткое описание статьи</p>',
            'content' => '<p>Полный текст статьи</p>',
            'category' => 'здоровье',
            'image' => '/storage/articles/test-rss.jpg',
            'active' => 1,
            'created_at' => now()->subHour(),
            'updated_at' => now()->subHour(),
        ]);

        $advise = Advise::query()->create([
            'title' => 'RSS Test Advise '.uniqid(),
            'alias' => 'rss-test-advise-'.uniqid(),
            'description' => '<p>Краткое описание совета</p>',
            'content' => '<p>Полный текст совета</p>',
            'category' => 'питание',
            'image' => '/storage/advises/test-rss.jpg',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/feeds/rss.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');
        $response->assertSee('<rss version="2.0"', false);
        $response->assertSee('<title>Система РЕПРО</title>', false);
        $response->assertSee($article->title, false);
        $response->assertSee($advise->title, false);
        $response->assertSee('/articles/'.$article->alias, false);
        $response->assertSee('/usefully-tips/'.$advise->alias, false);
        $response->assertSee('<![CDATA[Статьи]]>', false);
        $response->assertSee('<![CDATA[Советы]]>', false);
        $response->assertSee('<content:encoded>', false);
        $response->assertSee('Полный текст статьи', false);
        $response->assertSee('Полный текст совета', false);
        $response->assertSee('<image>', false);
        $response->assertSee('/storage/articles/test-rss.jpg', false);
    }

    public function test_feed_alias_route_works(): void
    {
        Cache::forget('feeds.rss');

        $response = $this->get('/feed');

        $response->assertOk();
        $response->assertSee('<rss version="2.0"', false);
    }
}
