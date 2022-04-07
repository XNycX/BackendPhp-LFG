<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PartyController extends Controller
{
    
            public function getAll()
    {
        try {
            $parties = Party::all();
            Log::info('get all parties done');
            $data = [
                'data' => $parties,
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
            $party = Party::create($request->all());
            Log::info('create party done');
            
            $data = [
                'data' => $party,
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
            $party = Party::find($id);
            Log::info('get party by id done');
            $data = [
                'data' => $party,
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
            $party = Party::find($id);
            $party->update($request->all());
            Log::info('update party done');
            
            $data = [
                'data' => $party,
                'sucess' => 'ok'
            ];
            return response()->json($data, 200);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
}
    }
}