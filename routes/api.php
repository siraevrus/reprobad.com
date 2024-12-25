<?php

use Illuminate\Support\Facades\Route;

/* create middleware group */
Route::group(['middleware' => ['web'], 'as' => 'admin.api.'], function () {

});

