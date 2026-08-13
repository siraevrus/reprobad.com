<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Complex;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GeoHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_exposes_csp_llms_speakable_and_visible_body_without_js(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertHeader('Content-Security-Policy');
        $this->assertStringContainsString("object-src 'none'", (string) $response->headers->get('Content-Security-Policy'));
        $response->assertSee('rel="alternate" type="text/plain" title="llms.txt"', false);
        $response->assertSee('/llms.txt', false);
        $response->assertSee('/llms-full.txt', false);
        $response->assertSee('type="application/rss+xml"', false);
        $response->assertSee('/rss.xml', false);
        $response->assertSee('"@type": "SpeakableSpecification"', false);
        $response->assertDontSee('html:not(.w-mod-js) body{visibility:hidden', false);
        $response->assertSee('html.w-mod-js body:not(.css-loaded){visibility:hidden', false);
        $this->assertStringContainsString('llms.txt', (string) $response->headers->get('Link'));
        $this->assertStringContainsString('rss.xml', (string) $response->headers->get('Link'));
        $response->assertSee('https://www.youtube.com/@reprobad', false);
        $response->assertSee('"parentOrganization"', false);
        $response->assertSee('АО «Р-Фарм»', false);
    }

    public function test_organization_address_is_structured_postal_address(): void
    {
        config([
            'address' => 'Поставщик АО "Р-Фарм". Почтовый адрес: 119421, г. Москва, Ленинский проспект, д.111, корп.1, этаж 5, ком.128.',
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('"postalCode": "119421"', false);
        $response->assertSee('"addressLocality": "Москва"', false);
        $response->assertSee('Ленинский проспект', false);
        $response->assertDontSee('"streetAddress": "Поставщик', false);
    }

    public function test_article_schema_has_speakable_and_no_editorial_policy_url(): void
    {
        $article = Article::query()->create([
            'title' => 'Как стресс влияет на репродуктивные функции',
            'alias' => 'geo-stress-test',
            'description' => 'Краткое описание',
            'content' => '<p>Текст статьи</p>',
            'category' => 'здоровье',
            'active' => 1,
        ]);

        $response = $this->get('/articles/'.$article->alias);

        $response->assertOk();
        $response->assertDontSee('editorial-policy', false);
        $response->assertSee('"@type": "SpeakableSpecification"', false);
        $response->assertSee('.article-content', false);
    }

    public function test_complex_json_ld_uses_commercial_product_names(): void
    {
        $complex = Complex::query()->create([
            'title' => 'Психоэмоциональное равновесие',
            'alias' => 'reprorelax',
            'subtitle' => 'Стресс',
            'active' => 1,
            'color' => 'purple',
            'sort' => 1,
        ]);

        Product::query()->create([
            'title' => 'Психо-эмоциональное равновесие',
            'alias' => 'relax-hyper',
            'description' => 'Описание',
            'active' => 1,
            'sort' => 1,
            'complex_id' => $complex->id,
        ]);
        Product::query()->create([
            'title' => 'Компоненты комплекса способствуют повышению устойчивости к стрессу',
            'alias' => 'relax-hypo',
            'description' => 'Описание',
            'active' => 1,
            'sort' => 2,
            'complex_id' => $complex->id,
        ]);

        $response = $this->get('/complex/reprorelax');

        $response->assertOk();
        $response->assertSee('РЕПРОРЕЛАКС ГИПЕРКОРТИЗОЛ', false);
        $response->assertSee('РЕПРОРЕЛАКС ГИПОКОРТИЗОЛ', false);
        $response->assertDontSee('"name": "Психо-эмоциональное равновесие"', false);
    }

    public function test_about_page_materializes_data_uri_images(): void
    {
        Storage::fake('public');

        $uri = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxIiBoZWlnaHQ9IjEiPjwvc3ZnPg==';

        Page::unguarded(function () use ($uri) {
            Page::query()->create([
                'id' => 3,
                'title' => 'О системе',
                'alias' => 'about',
                'description' => 'О системе РЕПРО',
                'active' => 1,
                'content' => [
                    [
                        'type' => 'block15',
                        'hide' => false,
                        'data' => [
                            'title' => 'Схема',
                            'subtitle' => '',
                            'image' => $uri,
                            'text' => '',
                        ],
                    ],
                ],
            ]);
        });

        $response = $this->get('/about');

        $response->assertOk();
        $response->assertDontSee('data:image', false);
        $response->assertSee('/storage/pages/', false);

        $page = Page::query()->find(3);
        $this->assertIsArray($page->content);
        $this->assertStringStartsWith('/storage/pages/', $page->content[0]['data']['image']);
    }

    public function test_llms_and_indexnow_key_files_exist(): void
    {
        $this->assertFileExists(public_path('llms.txt'));
        $this->assertFileExists(public_path('llms-full.txt'));
        $this->assertFileExists(public_path('a8f3c2e91b7d4e06a5c18f24d9e3b710.txt'));
        $this->assertStringContainsString('https://reprobad.com/complex/reprorelax', file_get_contents(public_path('llms.txt')));
        $this->assertStringContainsString('https://www.youtube.com/@reprobad', file_get_contents(public_path('llms.txt')));
        $this->assertStringContainsString('https://reprobad.com/rss.xml', file_get_contents(public_path('llms.txt')));
        $this->assertStringNotContainsString('ГИПРОКОРТИЗОЛ', file_get_contents(public_path('llms.txt')));
        $this->assertSame('a8f3c2e91b7d4e06a5c18f24d9e3b710', trim(file_get_contents(public_path('a8f3c2e91b7d4e06a5c18f24d9e3b710.txt'))));
    }

    public function test_robots_allows_google_other_and_facebook_bot(): void
    {
        $robots = file_get_contents(public_path('robots.txt'));

        $this->assertMatchesRegularExpression('/User-agent:\s*GoogleOther\s+Allow:\s*\//', $robots);
        $this->assertMatchesRegularExpression('/User-agent:\s*FacebookBot\s+Allow:\s*\//', $robots);
        $this->assertEquals(1, preg_match_all('/^User-agent:\s*GoogleOther\s*$/m', $robots));
        $this->assertEquals(1, preg_match_all('/^User-agent:\s*FacebookBot\s*$/m', $robots));
    }
}
