<?php

namespace Tests\Unit;

use App\Support\DataUriImageMaterializer;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DataUriImageMaterializerTest extends TestCase
{
    public function test_store_hashed_writes_svg_and_replaces_tree(): void
    {
        Storage::fake('public');

        $uri = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxIiBoZWlnaHQ9IjEiPjwvc3ZnPg==';
        $materializer = new DataUriImageMaterializer();

        $tree = [
            ['type' => 'block15', 'data' => ['image' => $uri, 'title' => 'Схема']],
        ];

        [$replaced, $changed] = $materializer->replaceDataUrisInTree($tree, 'pages');

        $this->assertTrue($changed);
        $this->assertStringStartsWith('/storage/pages/', $replaced[0]['data']['image']);
        $this->assertStringEndsWith('.svg', $replaced[0]['data']['image']);
        Storage::disk('public')->assertExists(ltrim(str_replace('/storage/', '', $replaced[0]['data']['image']), '/'));
    }

    public function test_public_asset_does_not_echo_data_uri(): void
    {
        Storage::fake('public');

        $uri = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxIiBoZWlnaHQ9IjEiPjwvc3ZnPg==';
        $url = public_asset($uri);

        $this->assertStringStartsWith('/storage/inline/', $url);
        $this->assertStringNotContainsString('data:image', $url);
    }
}
