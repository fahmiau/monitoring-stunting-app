<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class LoginController extends Controller
{
    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Email atau Password Tidak Sesuai',
            ],401);
        }
    
        $token = $user->createToken('apptoken')->plainTextToken;
        $role = $user->role;
        return response([
            'user' => $user,
            'token' => $token,
            'role' => $role
        ]);
    }

    public function logoutUser(Request $request)
    {
        auth()->user()->tokens()->delete();

        return ['message' => 'Logout Berhasil'];
    }
}
