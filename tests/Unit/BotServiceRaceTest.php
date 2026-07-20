<?php

namespace Tests\Unit;

use App\Services\BotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use ReflectionMethod;
use Tests\TestCase;

class BotServiceRaceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (! Schema::hasTable('config')) {
            Schema::create('config', function ($table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }
    }

    public function test_successful_chat_result_requires_non_empty_content(): void
    {
        $service = $this->app->make(BotService::class);
        $method = new ReflectionMethod(BotService::class, 'isSuccessfulChatResult');
        $method->setAccessible(true);

        $this->assertFalse($method->invoke($service, null));
        $this->assertFalse($method->invoke($service, []));
        $this->assertFalse($method->invoke($service, [
            'choices' => [['message' => ['content' => '']]],
        ]));
        $this->assertTrue($method->invoke($service, [
            'choices' => [['message' => ['content' => 'Ответ бота']]],
        ]));
    }
}
