<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
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

//CRUD USER
Route::prefix('users')->group(function () {
Route::get('/info', [UserController::class, 'getAll']);
Route::get('/{id}', [UserController::class, 'getById']);
Route::put('/{id}', [UserController::class, 'update']);
Route::delete('/{id}', [UserController::class, 'delete']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
});



//CRUD party
Route::prefix('parties')->group(function () {
Route::get('/info', [PartyController::class, 'getAll']);
Route::get('/{id}', [PartyController::class, 'getById']);
Route::post('getByGameId',[PartyController::class, "getByGameId"]);
Route::put('/{id}', [PartyController::class, 'update']);
Route::delete('/{id}', [PartyController::class, 'delete']);
Route::post('/create', [PartyController::class, 'create']);
});





