<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::prefix('produtos')->group(function () {
    Route::get('/',            [ProductController::class, 'index']);
    Route::get('/destaques',   [ProductController::class, 'featured']);
    Route::get('/{id}',        [ProductController::class, 'show']);

    Route::post('/',           [ProductController::class, 'store']);
    Route::match(['put','patch'], '/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}',     [ProductController::class, 'destroy']);
});