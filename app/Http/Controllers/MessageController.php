<?php

namespace App\Http\Controllers;

use App\Models\Belong;
use App\Models\Message;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function addMessage(Request $request) {
        $user = Auth::id();
        $partyId = $request->input('partyId');
        $message = $request->input('message');

        try {
            $isMember = Belong::where('userId', '=', $user)->where('partyId', '=', $partyId)->get();
            if ($isMember->isNotEmpty()) {
                return Message::create([
                    'from' => $user,
                    'message' => $message,
                    'partyId' => $partyId
                ]);
            } else {
                return response()->json([
                'error' => "You are not a member of that party"
            ]);
            }
        } 
        catch (QueryException $error) {
            $errorCode = $error->errorInfo[1];
            return response()->json([
                'error' => $errorCode
            ]);    
        }
    }
    public function getMessages() {
        try { 
            return Message::all();
        } 
        catch(QueryException $error) {
            return $error;
         }
    }
    public function updateMessage(Request $request) {
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
        catch (QueryException $error) {
            $errorCode = $error->errorInfo[1];
            return response()->json([
                'error' => $errorCode
            ]);   
        }
    }
    public function removeMessage(Request $request) {

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
        catch (QueryException $error) {
            $errorCode = $error->errorInfo[1];
            return response()->json([
                'error' => $errorCode
            ]); 
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
        catch (QueryException $error) {
            $errorCode = $error->errorInfo[1];
            return response()->json([
                'error' => $errorCode
            ]);    
        }
    }  
}
