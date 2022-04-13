<?php

namespace App\Http\Controllers;

use App\Models\Belong;
use App\Models\Party;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::id();
        $name = $request->input('name');
        $game = $request->input('gameId');

        try {
            $party = Party::create([
                    'owner' => $user,
                    'name' => $name,
                    'gameId' => $game
                ]);
            Belong::create([
                    'userId' => $user,
                    'partyId' => $party["id"]
                ]);
            Log::info('create party done');
            $data = [
                'data' => $party,
                'sucess' => 'ok'
            ];
            return response()->json($data, 200);
        }  
        catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function joinParty(Request $request) {

        $userId = Auth::id();
        $partyId = $request->input('partyId');

        try {

            $joinParty = Belong::where('userId', '=', $userId)->where('partyId', '=', $partyId)->get();

            if ($joinParty->isNotEmpty()) {
                return "You are already a member in that party";
            } 
            else {
            Belong::create([
                'userId' => $userId,
                'partyId' => $partyId
            ]);
            Log::info('join party done');
            $data = [
                'data' => 'ok',
                'sucess' => 'ok'
            ];
            return response()->json($data, 200);
            }
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
    }public function getByGameId(Request $request){
        $id = $request->input('id');
        try {
            $party = Party::selectRaw('parties.name , games.title, users.username')
            ->join('games', 'parties.GameID', '=', 'games.id')
            ->where('parties.GameID', "=", $id)
            ->join('users', 'parties.Owner', '=', 'users.id')
            ->get();
            return $party;

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function getPartiesByGameTitle(Request $request) {

        $gameTitle = $request->input('title');

        try {

            return Party::selectRaw('parties.gameId, parties.name as Party, games.title as Game')
            ->join('games', 'games.id', '=', 'parties.gameId')
            ->where('games.title', '=', $gameTitle)
            ->get();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function getMyParties() {
        $userId = Auth::id();
        try {
            $parties = Belong::selectRaw('parties.name, parties.gameId, games.title')
            ->join('parties', 'parties.id', '=', 'belongs.partyId')
            ->join('games', 'games.id', '=', 'parties.gameId')
            ->where('belongs.userId', '=', $userId)
            ->get();
            return $parties;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function getPartyMembers(Request $request) {
        $userId = Auth::id();
        $partyId = $request->input('partyId');

        try {

            $party = Party::selectRaw('belongs.partyId, parties.name, users.id, users.userName')
            ->join('belongs', 'belongs.partyId', '=', 'parties.id')
            ->join('users', 'users.id', '=', 'belongs.userId')
            ->where('parties.Id', '=', $partyId)
            ->orderByRaw('IF(users.id ='.$userId.', 0,1)')
            ->get();

            if ($party[0]['id'] === $userId) {
            return $party;
            } else {
                return "You are not a member of this party";
            }
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
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function delete($id)
    {
        try {
            $party = Party::find($id);
            $party->delete();
            Log::info('delete party done');
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
    public function leaveParty(Request $request) {
        $userId = Auth::id();
        $partyId = $request->input('partyId');

        try {

            $party = Belong::where('userId', '=', $userId)->where('partyId', '=', $partyId)->delete($userId);
            Log::info('leave party done');
            
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
    public function kickFromParty(Request $request) {
        $userId = Auth::id();
        $partyId = $request->input('partyId');
        $userToKick = $request->input('userToKick');

        try {

            return Belong::selectRaw('belongs.userId, belongs.partyId')
            ->join('parties', 'parties.id', '=', 'belongs.partyId')
            ->join('users', 'users.id', '=', 'belongs.userId')
            ->where('parties.owner', '=', $userId)
            ->where('parties.Id', '=', $partyId)
            ->where('belongs.userId', '=', $userToKick)
            ->delete($userToKick);

            Log::info('kick from party done');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

}