<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function getLoggedUser()
    {
        return Response::json(['status' => 'success', 'data' => Auth::user()], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->only(['name', 'password']), [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:4', 'max:255'],
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        if (!$token = Auth::attempt($validator->validated())) {
            return Response::json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->only(['name', 'email', 'password']), [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required','string', 'email','max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'max:255'],
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => Hash::make($request->password)]
        ));

        return Response::json(['status' => 'success', 'message' => 'User created successfully', 'data' => $user], 201);
    }

    public function logout()
    {
        Auth::logout();
        return Response::json(['status' => 'success', 'message' => 'User logged out successfully'], 200);
    }

    protected function createNewToken($token){
        return Response::json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 60 * 60,
            'user' => Auth::user()
        ]);
    }
}
