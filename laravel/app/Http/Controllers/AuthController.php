<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $validator->validate();
        // return $request->toArray();
        $user = \App\Models\User::where('email',$request->email)->first();
        // return $user;
        // return bcrypt($request->password);
        if(!$user) {
            return response()->json([
                'message' => 'Incorrect Credentials'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            if (Hash::check($request->password, $user->password)) {
                $key = 'Laravel-97eats';
                $time = time();
                $payload = [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'init' => $time,
                    'expires_at' => $time + (2 * 365 * 24 * 60 * 60)
                ];
                $token = JWT::encode($payload, $key);
                $tokenModel = new \App\Models\UserToken([
                    'token' => $token
                ]);
                $user->tokens()->save($tokenModel);
                return response()->json([
                    'message' => 'authenticated',
                    'token' => $token
                ]);
            } else {
                return response()->json([
                    'message' => 'Incorrect Credentials'
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()]
        ]);
        $validator->validate();
        $user = new \App\Models\User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'message' => 'success'
        ]);
    }
}
