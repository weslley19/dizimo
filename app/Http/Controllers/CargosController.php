<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CargosController extends Controller
{
    public function index()
    {
        $cargos = Cargo::all();
        return Response::json(['status' => 'success', 'data' => $cargos], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->only(['name']), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'data' => $validator->errors()], 400);
        }

        $cargo = Cargo::create($validator->validated());
        return Response::json(['status' =>'success', 'data' => $cargo], 201);
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->only(['name']), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'data' => $validator->errors()], 400);
        }

        $cargo = Cargo::find($request->id);
        $cargo->nome = $request->nome;
        $cargo->save();

        return Response::json(['status' =>'success', 'data' => $cargo], 200);
    }

    public function delete(Request $request)
    {
        $cargo = Cargo::find($request->id);
        $cargo->delete();
        return Response::json(['status' =>'success', 'data' => $cargo], 200);
    }
}
