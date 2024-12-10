<?php

use App\Http\Controllers\Admin\AdviseController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ComplexController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TextController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Site\FormController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\ArticleController as SiteArticleController;
use App\Http\Controllers\Site\IndexController as SiteIndexController;
use App\Http\Controllers\Site\EventController as SiteEventController;
use App\Http\Controllers\Site\ProductController as SiteProductController;
use App\Http\Controllers\Site\ComplexController as SiteComplexController;
use App\Http\Controllers\Site\AdviseController as SiteAdviseController;
use App\Http\Controllers\Site\TextController as SiteTextController;
use App\Http\Controllers\Site\PageController as SitePageController;
use App\Http\Controllers\Site\MapController as SiteMapController;

Route::group(['middleware' => ['auth'], 'as' => 'admin.'], function () {
    Route::get('/admin', [IndexController::class, 'index'])->name('index');
    Route::resource('/admin/articles', ArticleController::class);
    Route::resource('/admin/pages', PageController::class);
    Route::resource('/admin/complex', ComplexController::class);
    Route::resource('/admin/events', EventController::class);
    Route::resource('/admin/products', ProductController::class);
    Route::resource('/admin/advises', AdviseController::class);
    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/text', TextController::class);
    Route::get('/admin/config', [ConfigController::class, 'edit'])->name('config.edit');
    Route::post('/admin/config', [ConfigController::class, 'update'])->name('config.update');
    Route::get('/admin/icons', [ArticleController::class, 'icons'])->name('icons');

    Route::get('/admin/articles/{alias}/switch', [ArticleController::class, 'switch'])->name('articles.switch');
    Route::get('/admin/pages/{alias}/switch', [PageController::class, 'switch'])->name('pages.switch');
    Route::get('/admin/events/{alias}/switch', [EventController::class, 'switch'])->name('events.switch');
    Route::get('/admin/products/{alias}/switch', [ProductController::class, 'switch'])->name('products.switch');
    Route::get('/admin/advises/{alias}/switch', [AdviseController::class, 'switch'])->name('advises.switch');
    Route::get('/admin/users/{alias}/switch', [UserController::class, 'switch'])->name('users.switch');
    Route::get('/admin/text/{alias}/switch', [TextController::class, 'switch'])->name('text.switch');
    Route::get('/admin/complex/{alias}/switch', [ComplexController::class, 'switch'])->name('complex.switch');
});

Route::get('/', [SiteIndexController::class, 'index'])->name('site.index');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.auth');
Route::get('/login', [LoginController::class, 'form'])->name('login.form');
Route::get('/login', [LoginController::class, 'form'])->name('login');
Route::get('/articles', [SiteArticleController::class, 'index'])->name('site.articles.index');
Route::get('/articles/{alias}', [SiteArticleController::class, 'show'])->name('site.articles.show');
Route::get('/events', [SiteEventController::class, 'index'])->name('site.events.index');
Route::get('/events/{alias}', [SiteEventController::class, 'show'])->name('site.events.show');
Route::get('/products', [SiteProductController::class, 'index'])->name('site.products.index');
Route::get('/products/{alias}', [SiteProductController::class, 'show'])->name('site.products.show');
Route::get('/complex', [SiteComplexController::class, 'index'])->name('site.complex.index');
Route::get('/complex/{alias}', [SiteComplexController::class, 'show'])->name('site.complex.show');
Route::get('/text', [SiteTextController::class, 'index'])->name('site.text.index');
Route::get('/text/{alias}', [SiteTextController::class, 'show'])->name('site.text.show');
Route::get('/usefully-tips', [SiteAdviseController::class, 'index'])->name('site.advises.index');
Route::get('/usefully-tips/{alias}', [SiteAdviseController::class, 'show'])->name('site.advises.show');

Route::get('/company', [SitePageController::class, 'company'])->name('site.text.company');
Route::get('/privacy', [SitePageController::class, 'privacy'])->name('site.text.privacy');
Route::get('/about', [SitePageController::class, 'about'])->name('site.text.about');
Route::get('/contacts', [SitePageController::class, 'contacts'])->name('site.text.contacts');
Route::get('/map', [SiteMapController::class, 'index'])->name('site.map');

Route::post('/forms/feedback', [FormController::class, 'feedback'])->name('site.form.feedback');
Route::post('/forms/subscribe', [FormController::class, 'subscribe'])->name('site.form.subscribe');

