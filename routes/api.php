<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\TelegramController;
use App\Http\Controllers\Site\TelegramRelayInboundController;

/* create middleware group */
Route::group(['middleware' => ['web'], 'as' => 'admin.api.'], function () {

});

// Telegram webhook (если Telegram бьёт напрямую в РЕПРО; за рубежом чаще webhook на реле)
Route::post('/telegram/webhook', [TelegramController::class, 'webhook'])->name('telegram.webhook');

// Вход от реле (VPS с доступом к api.telegram.org): только AI, без вызовов Telegram API с РЕПРО
Route::post('/telegram/relay/process', [TelegramRelayInboundController::class, 'process'])
    ->middleware('telegram.relay')
    ->name('telegram.relay.process');

