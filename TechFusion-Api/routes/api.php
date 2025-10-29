<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});


Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);

use Illuminate\Http\Request;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin', function (Request $request) {
        if (!$request->user()->is_admin) {
            return response()->json(['message' => 'Acesso negado'], 403);
        }

        return response()->json([
            'message' => 'Bem-vindo ao Painel Administrativo!',
            'user' => $request->user(),
        ]);
    });
});