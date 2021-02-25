<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
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
        $token = $user->createToken('hJnvyHv6kGm8r1H5RvbRvikvNzGSrJysjPkEBq0y')->accessToken;
        $response = ['token' => $token, 'user'=> $user];

        return response($response, 200);
      
    }

    public function signup(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->get('password'));
        $user = User::create($input);
        $token = $user->createToken('MyApp')->accessToken;
        $response = ['token' => $token, 'user'=> $user];

        return response($response, 200);
      
    }
}
