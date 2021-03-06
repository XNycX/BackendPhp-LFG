<?php

use App\Http\Controllers\BelongController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\MessageController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:api')->group(function(){
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

});

//CRUD party
Route::prefix('parties')->group(function () {
Route::get('/info', [PartyController::class, 'getAll']);
Route::get('/getPartiesByGameId',[PartyController::class, "getByGameId"]);
Route::get('/getPartiesByGameTitle', [PartyController::class, 'getPartiesByGameTitle']);
Route::get('/getMyParties', [PartyController::class, 'getMyParties']);
Route::get('/getPartyMembers', [PartyController::class, 'getPartyMembers']);
Route::get('/{id}', [PartyController::class, 'getById']);
Route::post('/create', [PartyController::class, 'create']);
Route::post('/joinParty', [PartyController::class, 'joinParty']);
Route::put('/{id}', [PartyController::class, 'update']);
Route::delete('/leaveParty', [PartyController::class, 'leaveParty']);
Route::delete('/kickFromParty', [PartyController::class, 'kickFromParty']);
Route::delete('/party/{id}', [PartyController::class, 'delete']);

});

//CRUD message
Route::prefix('messages')->group(function () {
    Route::get('/info', [MessageController::class, 'getAll']);
    Route::post('/create', [MessageController::class, 'create']);
    Route::put('/update', [MessageController::class, 'update']);
    Route::delete('/delete', [MessageController::class, 'delete']);
    Route::get('/getPartyMessages', [MessageController::class, 'getPartyMessages']);

});

});





