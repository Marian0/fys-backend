<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {

            return response()->json([
                'message' => 'Wrong user'
            ], Response::HTTP_UNAUTHORIZED);

        }
        $user = User::where('email', $request->get('email'))->first();

        $userData = $user->toArray();
        $userData['api_token'] = $user->api_token;

        return response()->json([
            'user' => $userData
        ]);
    }
}
