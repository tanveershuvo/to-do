<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('Auth:api', ['except' => ['login','signup']]);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|JsonResponse
     */
    public function login(Request $request)
    {
         $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }
        return response()->json(['errors' =>
            ['msg'=>['Credential Mismatched !']]
        ], Response::HTTP_BAD_REQUEST);
    }

    public function signup(Request $request){
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        User::create($request->all());
        //dd($request->only('email', 'password'));
        return $this->login($request);

    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTFactory::getTTL() * 60,
            'user_name'=>auth()->user()->name,
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
