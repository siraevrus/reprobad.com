<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\TelegramController;

/* create middleware group */
Route::group(['middleware' => ['web'], 'as' => 'admin.api.'], function () {

});

// Telegram webhook
Route::post('/telegram/webhook', [TelegramController::class, 'webhook'])->name('telegram.webhook');

