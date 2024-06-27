<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Children;
use App\Models\Kader;
use App\Models\Mother;
use App\Models\StatusChildren;
use App\Models\TenagaKesehatan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class LoginController extends Controller
{
    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required',
            // 'email' => 'required|email:dns',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Email atau Password Tidak Sesuai',
            ],401);
        }
        $user->tokens()->delete();
        $token = $user->createToken('apptoken')->plainTextToken;
        $role = $user->role;
        // $user = Auth::user();
        return response([
            'user' => $user,
            'token' => $token,
            'role' => $role,
            'verified' => $user->hasVerifiedEmail(),
        ]);
    }

    public function logoutUser(Request $request)
    {
        auth()->user()->tokens()->delete();

        return ['message' => 'Logout Berhasil'];
    }

    public function dashboard()
    {
        $kader = Kader::count();
        $nakes = TenagaKesehatan::count();
        $mother = Mother::count();
        $data = [
            'user' => $kader + $nakes + $mother,
            'nakes' => $nakes,
            'kader' => $kader,
            'mother' => $mother,
            'article' => Article::count(),
            'children' => Children::count(),
            'status_sangat_dibawah' => StatusChildren::where('status_stunting','Sangat Dibawah Standar')->count(),
            'status_dibawah' => StatusChildren::where('status_stunting','Dibawah Standar')->count(),
            'status_normal' => StatusChildren::where('status_stunting','Normal')->count(),
            'status_diatas' => StatusChildren::where('status_stunting','Diatas Standar')->count(),

        ];
        return response($data);
    }
}
