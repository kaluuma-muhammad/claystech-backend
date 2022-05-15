<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'contact' => 'integer'
        ]);

        $user = User::create([
            'fname' => $fields['firstName'],
            'lname' => $fields['lastName'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'contact' => $fields['contact']
        ]);

        $token = $user->createToken('access_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();
        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            $response = [
                'message' => 'Either email or password is incorrect'
            ];

            return response($response, 401);
        }

        $token = $user->createToken('access_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function me() {
        return Auth::user();
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged Out'
        ];
    }
}
