<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(ProductController::class)
    ->prefix('v1')
    ->group(function () {
        Route::get('products', 'index');
        Route::get('product/{uuid}', 'show');
        Route::post('product/create', 'store');
        Route::put('product/{uuid}', 'update');
    });
