<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);

/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS (auth:sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Perfil e logout
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Painel administrativo
    Route::get('/admin', function (Request $request) {
        $user = $request->user();

        // Verifica se o usuário é admin
        if (!$user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Acesso negado. Você não possui permissão para acessar esta área.'
            ], 403);
        }

        // Retorna sucesso se for admin
        return response()->json([
            'success' => true,
            'message' => 'Bem-vindo ao Painel Administrativo!',
            'user' => $user,
        ]);
    });
});
