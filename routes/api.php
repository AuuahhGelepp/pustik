<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AnggotaController;
use App\Http\Controllers\Api\DivisiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Anggota Routes
Route::prefix('anggota')->group(function () {
    Route::get('/', [AnggotaController::class, 'index']);
    Route::get('/{id}', [AnggotaController::class, 'show']);
    Route::post('/', [AnggotaController::class, 'store']);
    Route::post('/{id}', [AnggotaController::class, 'update']);
    Route::delete('/{id}', [AnggotaController::class, 'destroy']);
});

// Divisi Routes
Route::prefix('divisi')->group(function () {
    Route::get('/', [DivisiController::class, 'index']);
    Route::get('/{id}', [DivisiController::class, 'show']);
    Route::post('/', [DivisiController::class, 'store']);
    Route::post('/{id}', [DivisiController::class, 'update']);
    Route::delete('/{id}', [DivisiController::class, 'destroy']);
    Route::get('/{id}/members', [DivisiController::class, 'members']);
}); 