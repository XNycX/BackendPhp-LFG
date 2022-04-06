<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function getAll()
    {
        try {
            $games = Game::all();
            Log::info('get all games done');
            $data = [
                'data' => $games,
                'sucess' => 'ok'
            ];
            return response()->json($data, 200);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function create(Request $request)
    {
        try {
            $game = Game::create($request->all());
            Log::info('create game done');
            
            $data = [
                'data' => $game,
                'sucess' => 'ok'
            ];
            return response()->json($data, 200);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function getById($id)
    {
        try {
            $game = Game::find($id);
            Log::info('get game by id done');
            $data = [
                'data' => $game,
                'sucess' => 'ok'
            ];
            return response()->json($data, 200);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $game = Game::find($id);
            $game->update($request->all());
            Log::info('update game done');
            $data = [
                'data' => $game,
                'sucess' => 'ok'
            ];
            return response()->json($data, 200);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function delete($id)
    {
        try {
            $game = Game::find($id);
            $game->delete();
            Log::info('delete game done');
            $data = [
                'data' => $game,
                'sucess' => 'ok'
            ];
            return response()->json($data, 200);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

}
