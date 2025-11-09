<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class authController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password, [
            'rounds' => 12,
        ]);
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->no_telepon = $request->no_telepon;
        $user->save();

        return response()->json([
            'status' => 'succes',
            'message' => 'User Registered',
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'false',
                'message' => 'User Tidak Ditemukan!'
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'false',
                'message' => 'Password Salah!'
            ], 404);
        }

        $token = $user->createToken('Auth Token')->accessToken;
        return response()->json([
            'status' => 'succes',
            'message' => 'Login Succes',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 200);

    }
}
