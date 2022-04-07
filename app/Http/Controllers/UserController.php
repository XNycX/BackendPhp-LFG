<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getAll()
    {
        try {
            $users = User::all();
            Log::info('get all users done');
            $data = [
                'data' => $users,
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
            $user = User::create($request->all());
            Log::info('create user done');
            
            $data = [
                'data' => $user,
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
            $user = User::find($id);
            Log::info('get user by id done');
            $data = [
                'data' => $user,
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
            $user = User::find($id);
            $user->update($request->all());
            Log::info('update user done');
            
            $data = [
                'data' => $user,
                'sucess' => 'ok'
            ];
            return response()->json($data, 200);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }public function delete(Request $request) {
        try {
            $user = User::find($request->id);
            $user->delete();
            Log::info('delete user done');
            
            $data = [
                'data' => $user,
                'sucess' => 'ok'
            ];
            return response()->json($data, 200);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()], 500);
        }
       

        

    }

}