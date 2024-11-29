<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web'], 'as' => 'admin.'], function () {
    Route::resource('/admin/articles', ArticleController::class);
    Route::resource('/admin/pages', PageController::class);
    Route::get('/admin', [IndexController::class, 'index'])->name('index');
    Route::get('/admin/config', [ConfigController::class, 'edit'])->name('config.edit');
});
