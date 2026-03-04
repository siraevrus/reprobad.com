<?php

use App\Http\Controllers\Admin\AdviseController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ComplexController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PointController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\StepController;
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\Admin\TextController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\TestResultController;
use App\Http\Controllers\Admin\TestQuestionController;
use App\Http\Controllers\Admin\TestResultFieldController;
use App\Http\Controllers\Admin\ChatHistoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ShortLinkController;
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
use App\Http\Controllers\Site\FaqController as SiteFaqController;
use App\Http\Controllers\Site\MenuController as SiteMenuController;
use App\Http\Controllers\Site\TestController as SiteTestController;
use App\Http\Controllers\ShortLinkRedirectController;

Route::get('/s/{code}', [ShortLinkRedirectController::class, 'redirect'])->name('short.redirect');

Route::group(['middleware' => ['auth'], 'as' => 'admin.'], function () {
    Route::get('/admin', [IndexController::class, 'index'])->name('index');
    Route::resource('/admin/articles', ArticleController::class);
    Route::resource('/admin/pages', PageController::class);
    Route::resource('/admin/complex', ComplexController::class);
    Route::resource('/admin/events', EventController::class);
    Route::resource('/admin/products', ProductController::class);
    Route::resource('/admin/advises', AdviseController::class);
    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/faq', FaqController::class);
    Route::resource('/admin/text', TextController::class);
    Route::resource('/admin/points', PointController::class);
    Route::resource('/admin/questions', QuestionController::class);
    Route::resource('/admin/subscribers', SubscribeController::class);
    Route::resource('/admin/steps', StepController::class);
    Route::resource('/admin/menus', MenuController::class);
    Route::resource('/admin/short-links', ShortLinkController::class);
    Route::get('/admin/chat-history/export', [ChatHistoryController::class, 'export'])->name('chat-history.export');
    Route::resource('/admin/chat-history', ChatHistoryController::class)->only(['index', 'show', 'destroy']);
    Route::resource('/admin/feedbacks', \App\Http\Controllers\Admin\FeedbackController::class)->only(['index', 'show', 'destroy']);
    Route::resource('/admin/test-results', TestResultController::class)->only(['index', 'show', 'destroy']);
    Route::resource('/admin/test-questions', TestQuestionController::class);
    Route::resource('/admin/test-result-fields', TestResultFieldController::class);

    // Загрузка файлов (AJAX)
    Route::post('/admin/upload', [FileManagerController::class, 'upload'])->name('upload');
    Route::post('/admin/upload-image-base64', [FileManagerController::class, 'uploadBase64'])->name('upload.image-base64');

    // Файловый менеджер
    Route::get('/admin/file-manager', [FileManagerController::class, 'index'])->name('file-manager.index');
    Route::post('/admin/file-manager', [FileManagerController::class, 'store'])->name('file-manager.store');
    Route::delete('/admin/file-manager/{filename}', [FileManagerController::class, 'destroy'])->name('file-manager.destroy');

    // SEO управление
    Route::get('/admin/seo', [SeoController::class, 'index'])->name('seo.index');
    Route::get('/admin/seo/create', [SeoController::class, 'create'])->name('seo.create');
    Route::post('/admin/seo', [SeoController::class, 'store'])->name('seo.store');
    Route::get('/admin/seo/{id}/edit', [SeoController::class, 'edit'])->name('seo.edit');
    Route::put('/admin/seo/{id}', [SeoController::class, 'update'])->name('seo.update');
    Route::delete('/admin/seo/{id}', [SeoController::class, 'destroy'])->name('seo.destroy');

    Route::get('/admin/config', [ConfigController::class, 'edit'])->name('config.edit');
    Route::post('/admin/config', [ConfigController::class, 'update'])->name('config.update');
    Route::get('/admin/icons', [ArticleController::class, 'icons'])->name('icons');

    Route::get('/admin/faq/{alias}/switch', [FaqController::class, 'switch'])->name('faq.switch');
    Route::get('/admin/articles/{alias}/switch', [ArticleController::class, 'switch'])->name('articles.switch');
    Route::get('/admin/pages/{alias}/switch', [PageController::class, 'switch'])->name('pages.switch');
    Route::get('/admin/events/{alias}/switch', [EventController::class, 'switch'])->name('events.switch');
    Route::get('/admin/products/{alias}/switch', [ProductController::class, 'switch'])->name('products.switch');
    Route::get('/admin/advises/{alias}/switch', [AdviseController::class, 'switch'])->name('advises.switch');
    Route::get('/admin/users/{alias}/switch', [UserController::class, 'switch'])->name('users.switch');
    Route::get('/admin/text/{alias}/switch', [TextController::class, 'switch'])->name('text.switch');
    Route::get('/admin/complex/{alias}/switch', [ComplexController::class, 'switch'])->name('complex.switch');
    Route::get('/admin/points/{alias}/switch', [PointController::class, 'switch'])->name('points.switch');
    Route::get('/admin/questions/{alias}/switch', [QuestionController::class, 'switch'])->name('questions.switch');
    Route::get('/admin/steps/{alias}/switch', [StepController::class, 'switch'])->name('steps.switch');
    Route::get('/admin/menus/{id}/switch', [MenuController::class, 'switch'])->name('menus.switch');

    Route::get('/admin/products/{alias}/up', [ProductController::class, 'up'])->name('products.up');
    Route::get('/admin/complex/{alias}/up', [ComplexController::class, 'up'])->name('complex.up');
    Route::get('/admin/events/{alias}/up', [EventController::class, 'up'])->name('events.up');

    Route::get('/admin/products/{alias}/down', [ProductController::class, 'down'])->name('products.down');
    Route::get('/admin/complex/{alias}/down', [ComplexController::class, 'down'])->name('complex.down');
    Route::get('/admin/events/{alias}/down', [EventController::class, 'down'])->name('events.down');

    Route::get('/admin/articles/{alias}/home', [ArticleController::class, 'home'])->name('articles.home');
    Route::get('/admin/events/{alias}/home', [EventController::class, 'home'])->name('events.home');
    Route::get('/admin/advises/{alias}/home', [AdviseController::class, 'home'])->name('advises.home');
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
//Route::get('/products/{alias}', [SiteProductController::class, 'show'])->name('site.products.show');
Route::get('/complex', [SiteComplexController::class, 'index'])->name('site.complex.index');
Route::get('/complex/{alias}', [SiteComplexController::class, 'show'])->name('site.complex.show');
Route::get('/text', [SiteTextController::class, 'index'])->name('site.text.index');
Route::get('/text/{alias}', [SiteTextController::class, 'show'])->name('site.text.show');
Route::get('/usefully-tips', [SiteAdviseController::class, 'index'])->name('site.advises.index');
Route::get('/usefully-tips/{alias}', [SiteAdviseController::class, 'show'])->name('site.advises.show');
Route::get('/faq', [SiteFaqController::class, 'index'])->name('site.faq.index');
Route::get('/menu', [SiteMenuController::class, 'index'])->name('site.menus.index');
Route::get('/menu/{alias}', [SiteMenuController::class, 'show'])->name('site.menus.show');

Route::get('/company', [SitePageController::class, 'company'])->name('site.text.company');
Route::get('/privacy', [SitePageController::class, 'privacy'])->name('site.text.privacy');
Route::get('/about', [SitePageController::class, 'about'])->name('site.text.about');
Route::get('/about.html', function () {
    return redirect()->route('site.text.about', [], 301);
});
Route::get('/contacts', [SitePageController::class, 'contacts'])->name('site.text.contacts');
Route::get('/map', [SiteMapController::class, 'index'])->name('site.map');

Route::post('/forms/feedback', [FormController::class, 'feedback'])->name('site.form.feedback');
Route::post('/forms/subscribe', [FormController::class, 'subscribe'])->name('site.form.subscribe');
Route::post('/forms/city', [FormController::class, 'setCity'])->name('site.form.city');
Route::post('/articles/{alias}/like', [SiteArticleController::class, 'like'])->name('site.articles.like');
Route::post('/usefully-tips/{alias}/like', [SiteAdviseController::class, 'like'])->name('site.advises.like');

// Чат-бот на сайте
use App\Http\Controllers\Site\BotController;
Route::post('/bot/ask', [BotController::class, 'ask'])->name('site.bot.ask');
Route::post('/bot/clear-history', [BotController::class, 'clearHistory'])->name('site.bot.clearHistory');

// Тест "Репродуктивное здоровье"
Route::get('/test', [SiteTestController::class, 'index'])->name('site.test.index');
Route::post('/test/calculate', [SiteTestController::class, 'calculate'])->name('site.test.calculate');
Route::post('/test/update-email', [SiteTestController::class, 'updateEmail'])->name('site.test.update-email');
Route::post('/test/subscribe', [SiteTestController::class, 'subscribe'])->name('site.test.subscribe');

