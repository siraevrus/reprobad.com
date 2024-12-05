<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\PageController;
use Illuminate\Support\Facades\Route;

/* create middleware group */
Route::group(['middleware' => ['web'], 'as' => 'admin.api.'], function () {

});

