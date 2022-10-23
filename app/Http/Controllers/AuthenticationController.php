<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function signup(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'phone' => $fields['phone'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);
        $token = $user->createToken('crudtoken')->plainTextToken;

        $response = [
            'token' => $token,
            'user' => $user
        ];
        return response($response, 201);
    }
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $fields['email'])->first();
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Bad credentials'], 401);
        }
        $token = $user->createToken('crudtoken')->plainTextToken;
        return response([
            'message' => 'logged in',
            'user' => $user,
            'token' => $token
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ['message' => 'Logged out'];
    }
}
