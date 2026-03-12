<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * User Login API
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        if ($user->status === 'blocked') {
            return response()->json([
                'status' => false,
                'message' => 'Account is blocked'
            ], 403);
        } 

        if ( $request->password != $user->password) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ], 401);
         }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'data' => [
                'user_id' => $user->user_id,
                'name'    => $user->name,
                'email'   => $user->email,
                'role'    => $user->role
            ]
        ], 200);
    }

     public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => true,
            'data' => $users
        ]);
    }



   

    /**
     * Create new user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,agent,user',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // or Hash::make($request->password)
            'role'     => $request->role,
            'status'   => 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }

    /**
     * Show single user
     */
    public function show($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }

    /**
     * Update user
     */
    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'sometimes|required|string|max:255',
'email' => 'sometimes|required|email|unique:users,email,' . $user_id . ',user_id',
            'password' => 'sometimes|required|string|min:6',
            'role'     => 'sometimes|required|in:admin,agent,customer',
            'status'   => 'sometimes|required|in:active,blocked',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = $request->password; // or Hash::make($request->password)
        }

        if ($request->has('role')) {
            $user->role = $request->role;
        }

        if ($request->has('status')) {
            $user->status = $request->status;
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    /**
     * Delete user
     */
    public function destroy($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}


