<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'password_confirmed' => 'required|same:password'
        ]);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return response($user);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function login(Request $request)
    {
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                $token = $user->createToken('token')->accessToken;
                return response([
                    'message' => 'Success',
                    'token' => $token,
                    'user' => $user
                ]);
            } else {
                return response([
                    'message' => 'Invalid Username or Password'
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function user(User $user)
    {
        try {
            return response($user);
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage()
            ], Response::HTTP_OK);
        }
    }

    public function logout()
    {
        try {
            Auth::user()->AuthAccessToken()->delete();
            return response([
                'message' => "User Logged Out"
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
