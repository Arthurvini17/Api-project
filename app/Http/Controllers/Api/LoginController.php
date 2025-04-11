<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $user = Auth::user(); // ou User::where('email', $request->email)->first()
    
            $token = $user->createToken('api-token')->plainTextToken;
    
            return response()->json([
                'status' => true,
                'user' => $user,
                'token' => $token,
            ], 201);
            
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Login ou senha incorreta'
            ], 401);
        }
    }
}    
