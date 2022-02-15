<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6|max:255|confirmed'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        $user = User::create($validated);
        if (isset($validated['category'])) {
            $role = Role::create([
                'user_id' => $user->id,
                'category' => $validated['category'],
            ]);
        } else {
            $role = Role::create([
                'user_id' => $user->id,
                'category' => 'User',
            ]);
            $token = $user->createToken('apptoken')->plainTextToken;
        }

        $response = [
            'user' => $user,
            'role' => $role,
            'token' => $token
        ];
                
        return response($response,201);

    }
}
