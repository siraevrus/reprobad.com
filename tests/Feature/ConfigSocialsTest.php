<?php

namespace Tests\Feature;

use App\Models\Config;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConfigSocialsTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_social_fields_are_saved_and_clear_existing_urls(): void
    {
        Config::query()->create(['key' => 'address', 'value' => 'Москва']);
        Config::query()->create(['key' => 'phone', 'value' => '+7 495 000 00 00']);
        Config::query()->create(['key' => 'vk', 'value' => 'https://vk.com/club228615718']);
        Config::query()->create(['key' => 'youtube', 'value' => 'https://www.youtube.com/@reprobad']);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.config.update'), [
            'address' => 'Москва',
            'phone' => '+7 495 000 00 00',
            'telegram' => '',
            'youtube' => '',
            'rutube' => '',
            'ok' => '',
            'vk' => '',
            'dzen' => '',
        ]);

        $response->assertRedirect();
        $this->assertSame('', (string) Config::query()->where('key', 'vk')->value('value'));
        $this->assertSame('', (string) Config::query()->where('key', 'youtube')->value('value'));
    }
}
