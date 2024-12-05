<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\ArticleController as SiteArticleController;
use App\Http\Controllers\Site\IndexController as SiteIndexController;

Route::group(['middleware' => ['web'], 'as' => 'admin.'], function () {
    Route::resource('/admin/articles', ArticleController::class);
    Route::resource('/admin/pages', PageController::class);
    Route::get('/admin', [IndexController::class, 'index'])->name('index');
    Route::get('/admin/config', [ConfigController::class, 'edit'])->name('config.edit');
});

Route::get('/', [SiteIndexController::class, 'index'])->name('site.index');
Route::get('/articles.html', [SiteArticleController::class, 'index'])->name('site.article.index');
Route::get('/articles/{alias}', [SiteArticleController::class, 'show'])->name('site.article.show');
