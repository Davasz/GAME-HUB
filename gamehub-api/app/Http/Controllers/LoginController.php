<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only("email", "password"))) {
            return response()->json([
                "mensage" => "Authorized",
                "token" => $request->user()->createToken("user_token")->plainTextToken
            ]);
        }
                    
        return response()->json(["mesage" => "Unauthorized"], Response::HTTP_UNAUTHORIZED);
    }
}