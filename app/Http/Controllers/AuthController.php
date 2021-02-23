<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            $response = ["message" => "Invalid email or password"];
            return response($response, 422);
        }

        $user = $request->user();
        $token = $user->createToken('test123456789')->accessToken;
        $response = ['token' => $token, 'user'=> $user];

        return response($response, 200);
      
    }
}
