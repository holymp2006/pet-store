<?php

declare(strict_types=1);

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

Route::prefix('v1')->group(function () {
    Route::controller(ProductController::class)
        ->group(function (): void {
            Route::get('products', 'index');
            Route::get('product/{uuid}', 'show');
            
            Route::middleware(['auth:api', 'admin'])
                ->group(function (): void {
                    Route::post('product/create', 'store');
                    Route::put('product/{uuid}', 'update');
                });
        });

    Route::controller(OrderController::class)
        ->middleware('auth:api')
        ->group(function (): void {
            Route::get('orders', 'index');
        });
});
