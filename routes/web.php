<?php

use Illuminate\Support\Facades\Route;
use StarfolkSoftware\Pigeonhole\Http\Controllers\CategoryController;

Route::group([
    'middleware' => config('pigeonhole.middleware', ['web']),
], function () {
    Route::resource('categories', CategoryController::class)->only(['store', 'update', 'destroy']);
});