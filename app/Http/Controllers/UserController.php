<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //inertia render
        return inertia('HomePage');
    }

    public function Registration(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            $user = User::create([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'profile_photo' => $request->input('profile_photo'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'data' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ]);
        }
    }
}
