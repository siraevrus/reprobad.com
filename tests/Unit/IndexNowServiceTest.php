<?php

namespace Tests\Unit;

use App\Services\IndexNowService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IndexNowServiceTest extends TestCase
{
    public function test_submit_posts_payload_when_enabled(): void
    {
        config([
            'indexnow.enabled' => true,
            'indexnow.key' => 'a8f3c2e91b7d4e06a5c18f24d9e3b710',
            'indexnow.endpoint' => 'https://api.indexnow.org/indexnow',
            'app.url' => 'https://reprobad.com',
        ]);

        Http::fake([
            'https://api.indexnow.org/indexnow' => Http::response('', 200),
        ]);

        $ok = (new IndexNowService())->submit(['https://reprobad.com/about']);

        $this->assertTrue($ok);
        Http::assertSent(function ($request) {
            $data = $request->data();

            return $request->url() === 'https://api.indexnow.org/indexnow'
                && $data['host'] === 'reprobad.com'
                && $data['key'] === 'a8f3c2e91b7d4e06a5c18f24d9e3b710'
                && $data['urlList'] === ['https://reprobad.com/about'];
        });
    }

    public function test_submit_skips_when_disabled(): void
    {
        config(['indexnow.enabled' => false]);
        Http::fake();

        $this->assertFalse((new IndexNowService())->submit(['https://reprobad.com/']));
        Http::assertNothingSent();
    }
}
