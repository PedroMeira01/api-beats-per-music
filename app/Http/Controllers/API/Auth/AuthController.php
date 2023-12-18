<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request) {
        
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are invalid.']
            ]);
        }

        $user->tokens()->delete();

        $token = $user->createToken($request->device_name)->plainTextToken; 

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $request) {
        
        $request->user()->tokens()->delete();
    
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function me(Request $request) {
        
        $user = $request->user()->tokens()->delete();
    
        return response()->json([
            'user' => $user,
        ]);
    }
    
}