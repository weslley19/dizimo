<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Response::json(['status' => 'success', 'data' => $users], 200);
    }

    public function create(Request $request)
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

    public function edit(Request $request)
    {
        $validator = Validator::make($request->only(['name', 'password']), [
            'name' => ['required','string','max:255'],
            'password' => ['required','string','min:4','max:255'],
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'data' => $validator->errors()], 400);
        }

        $user = User::find($request->id);
        $user->name = mb_strtolower($request->name);
        $user->password = Hash::make($request->password);
        $user->save();

        return Response::json(['status' =>'success', 'data' => $user], 200);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return Response::json(['status' => 'success', 'message' => 'User deleted successfully'], 200);
    }
}
