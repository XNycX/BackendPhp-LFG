<?php

use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//CRUD game

Route::prefix('games')->group(function () {
Route::get('/info', [GameController::class, 'getAll']);
Route::post('/create', [GameController::class, 'create']);
Route::get('/{id}', [GameController::class, 'getById']);
Route::put('/{id}', [GameController::class, 'update']);
Route::delete('/{id}', [GameController::class, 'delete']);
});