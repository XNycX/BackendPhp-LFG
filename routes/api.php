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
Route::get('/info', GameController::class, 'getAll');
Route::get('/game/{id}', GameController::class, 'getById');
Route::post('/create', GameController::class, 'create');
Route::put('/game/{id}', GameController::class, 'update');
Route::delete('/game/{id}', GameController::class, 'delete');
});