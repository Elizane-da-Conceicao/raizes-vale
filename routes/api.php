<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FamiliaController;
use App\Http\Controllers\FamiliaColonizadoraController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\DescendenciaController;
use App\Http\Controllers\CasalController;
use App\Http\Controllers\ArvoreController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index']);
    Route::post('/', [UsuarioController::class, 'store']);
    Route::get('/{id}', [UsuarioController::class, 'show']);
    Route::put('/{id}', [UsuarioController::class, 'update']);
    Route::delete('/{id}', [UsuarioController::class, 'destroy']);
    Route::post('/logar', [UsuarioController::class, 'logar']);
});

Route::prefix('documentos')->group(function () {
    Route::get('/', [DocumentoController::class, 'index']);
    Route::post('/', [DocumentoController::class, 'store']);
    Route::get('/{id}', [DocumentoController::class, 'show']);
    Route::put('/{id}', [DocumentoController::class, 'update']);
    Route::delete('/{id}', [DocumentoController::class, 'destroy']);
});

Route::prefix('pessoas')->group(function () {
    Route::get('/', [PessoaController::class, 'index']);
    Route::post('/', [PessoaController::class, 'store']);
    Route::get('/{id}', [PessoaController::class, 'show']);
    Route::put('/{id}', [PessoaController::class, 'update']);
    Route::delete('/{id}', [PessoaController::class, 'destroy']);
});

Route::prefix('familias')->group(function () {
    Route::get('/', [FamiliaController::class, 'index']);
    Route::post('/', [FamiliaController::class, 'store']);
    Route::get('/{id}', [FamiliaController::class, 'show']);
    Route::put('/{id}', [FamiliaController::class, 'update']);
    Route::delete('/{id}', [FamiliaController::class, 'destroy']);
});

Route::prefix('familias-colonizadoras')->group(function () {
    Route::get('/', [FamiliaColonizadoraController::class, 'index']);
    Route::post('/', [FamiliaColonizadoraController::class, 'store']);
    Route::get('/{id}', [FamiliaColonizadoraController::class, 'show']);
    Route::put('/{id}', [FamiliaColonizadoraController::class, 'update']);
    Route::delete('/{id}', [FamiliaColonizadoraController::class, 'destroy']);
});

Route::prefix('casais')->group(function () {
    Route::get('/', [CasalController::class, 'index']);
    Route::post('/', [CasalController::class, 'store']);
    Route::get('/{id}', [CasalController::class, 'show']);
    Route::put('/{id}', [CasalController::class, 'update']);
    Route::delete('/{id}', [CasalController::class, 'destroy']);
});

Route::prefix('descendencias')->group(function () {
    Route::get('/', [DescendenciaController::class, 'index']);
    Route::post('/', [DescendenciaController::class, 'store']);
    Route::get('/{id}', [DescendenciaController::class, 'show']);
    Route::put('/{id}', [DescendenciaController::class, 'update']);
    Route::delete('/{id}', [DescendenciaController::class, 'destroy']);
});

Route::prefix('arvores')->group(function () {
    Route::get('/', [ArvoreController::class, 'index']);
    Route::post('/', [ArvoreController::class, 'store']);
    Route::get('/busca/{id}', [ArvoreController::class, 'show']);
    Route::put('/{id}', [ArvoreController::class, 'update']);
    Route::delete('/{id}', [ArvoreController::class, 'destroy']);
    Route::get('/montar/{id}', [ArvoreController::class, 'montar']);
    Route::get('/montar-pessoa/{id}', [ArvoreController::class, 'montarArvorePessoa']);
});
