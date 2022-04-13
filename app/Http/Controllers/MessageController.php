<?php

namespace App\Http\Controllers;

use App\Models\Belong;
use App\Models\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function create(Request $request) {
        $user = Auth::id();
        $partyId = $request->input('partyId');
        $message = $request->input('message');

        try {
            $isMember = Belong::where('userId', '=', $user)->where('partyId', '=', $partyId)->get();
            if ($isMember->isNotEmpty()) {
                return Message::create([
                    'userId' => $user,
                    'message' => $message,
                    'partyId' => $partyId
                ]);
            } else {
                return response()->json([
                'error' => "You are not a member of that party"
            ]);
            }
        } 
        catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);     
        }
    }
    public function getAll() {
        try { 
            return Message::all();
        } 
        catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
         }
    }
    public function update(Request $request) {
        $user = Auth::id();
        $messageId = $request->input('messageId');
        try {
            $isSender = Message::where('from', '=', $user)->where('id', '=', $messageId)->get();
            if ($isSender->isNotEmpty()) {
                $msg = ['message'=>$request->message];
                return Message::where('id', '=', $messageId)->update($msg);
            } else {
                return response()->json([
                'error' => "There was a problem updating the message"
            ]);
            }
        } 
        catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);     
        }
    }
    public function delete(Request $request) {

        $user = Auth::id();
        $messageId = $request->input('messageId');

        try {

            $isSender = Message::where('from', '=', $user)->where('id', '=', $messageId)->get();

            $isOwner = Message::selectRaw('messages.id, messages.partyId')
            ->Join('parties', 'parties.id', '=', 'messages.partyId')
            ->where('messages.id', '=', $messageId)
            ->where('parties.owner', '=', $user)
            ->get();

            if ($isSender->isNotEmpty()|$isOwner->isNotEmpty()) {
                return Message::where('id', '=', $messageId)->delete($messageId);
            } else {
                return response()->json([
                'error' => "There was a problem deleting the message"
                ]);
            }
        }   
        catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function getPartyMessages(Request $request) {

        $user = Auth::id();
        $partyId = $request->input('partyId');

        try {
            $isMember = Belong::where('userId', '=', $user)->where('partyId', '=', $partyId)->get();
            if ($isMember->isNotEmpty()) {
                return Message::selectRaw('messages.id as MessageId, messages.message, users.userName, messages.created_at as Date')
                    ->Join('users', 'users.id', '=', 'messages.from')
                    ->where('messages.partyId', '=', $partyId)
                    ->get();  
            } else {
                return response()->json([
                'error' => "You cannot view the messages"
                ]);
            }
        } 
        catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);     
        }
    }  
}
