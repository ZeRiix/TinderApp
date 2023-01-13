<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return 'Hello World';
    }

    public function addUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:user',
                'password' => 'required|string',
            ]);
    
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = sha1($request->password);
            $user->save();

            return response()->json([
                'message' => 'User added successfully',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error adding user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUsers()
    {
        try {
            $users = User::all();
            return response()->json([
                'message' => 'Users fetched successfully',
                'users' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUser(Request $request)
    {
        try {

            $request->validate([
                '_id' => 'required|string'
            ]);

            $id = $request->_id;

            $user = User::where('_id', $id)->first();
            return response()->json([
                'message' => 'User fetched successfully',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function authUser(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $email = $request->email;
            $password = sha1($request->password);

            $user = User::where('email', $email)->where('password', $password)->first();

            if ($user) {
                return response()->json([
                    'message' => 'User authenticated successfully',
                    'user' => $user
                ], 200);
            } else {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error authenticating user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delUser(Request $request)
    {
        try {
            $request->validate([
                '_id' => 'required|string|exists:user'
            ]);

            $id = $request->_id;

            $user = User::find($id);
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $request->validate([
                '_id' => 'required|string|exists:user',
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $id = $request->_id;

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = sha1($request->password);
            $user->save();

            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
        
}
