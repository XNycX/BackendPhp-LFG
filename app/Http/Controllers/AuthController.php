<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'userName' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'steamUserName' => 'required|string|min:6'
        ], [

            'userName' => 'userName is required',
            'email' => 'Email is required',
            'password' => 'Password is required',
            'steamUserName' => 'SteamUserName is required'
        ]);
        try {
            $user = User::create([
                'userName' => $request->userName,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'steamUserName' => $request->steamUserName
            ]);
            return response()->json([
                'user' => $user
            ], 201);
        } catch (QueryException $error) {
            $errorCode = $error->errorInfo[1];
            if ($errorCode == 1062) {
                return response()->json(['error' => 'Email already registered']);
            }
        }
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email' => 'Email is required',
            'password' => 'Password is required'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
            } else {
                return response()->json(['error' => 'Password is incorrect'], 401);
            }
        } else {
            return response()->json(['error' => 'Email is incorrect'], 401);
        }
        
    }

    public function logout() { 
        try {
            $user = Auth::user();
            $token = $user->token();
            $token->revoke();
            return response()->json(['message' => 'Logout successfully'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
       
