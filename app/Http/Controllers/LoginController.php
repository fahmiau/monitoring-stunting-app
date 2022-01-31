<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function loginUser(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email:dns'],
            'password' => ['required'],
        ]);

        return response()->json(['status'=>'Login Berhasil',200]);
        if (Auth::attemp($credentials)) {
            return response()->json($credentials);
        }
    }
}
