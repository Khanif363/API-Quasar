<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        return response([
            'message' => 'Successfully created user!',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('myapptoken')->plainTextToken;
                return response([
                    'message' => 'Successfully logged in!',
                    'user' => $user,
                    'token' => $token
                ], 200);
            } else {
                return response([
                    'message' => 'Wrong password!'
                ], 401);
            }
        } else {
            return response([
                'message' => 'User not found!'
            ], 404);
        }

    }

    // public function logout(Request $request)
    // {
    //     $request->user()->token()->revoke();
    //     return response([
    //         'message' => 'Successfully logged out!'
    //     ], 200);
    // }

}
