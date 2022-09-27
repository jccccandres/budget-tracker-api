<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\V1\UserResource;
use App\Http\Requests\V1\StoreUserRequest;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($fields)) {
            $user = new UserResource(Auth::user());
            $token = $user->createToken('user-token')->plainTextToken;
            return [
                'data' => $user, 
                'token' => $token
            ];
        }
        else {
            return response([
                'message' => 'Invalid credentials.'
            ],401);
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged Out!'
        ];
    }

    public function register(StoreUserRequest $request)
    {
        return new UserResource(User::create($request->all()));
    }
}
