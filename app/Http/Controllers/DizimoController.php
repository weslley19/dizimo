<?php

namespace App\Http\Controllers;

use App\Models\Dizimo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class DizimoController extends Controller
{
    public function index()
    {
        $dizimos = Dizimo::all();
        return Response::json(['status' => 'success', 'data' => $dizimos], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->only(['value', 'month', 'year', 'user_id']), [
            'value' => ['required', 'numeric'],
            'month' => ['required', 'integer'],
            'year' => ['required', 'integer'],
            'user_id' => ['required', 'integer', 'max:255'],
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'data' => $validator->errors()], 400);
        }

        $cargo = Dizimo::create($validator->validated());
        return Response::json(['status' =>'success', 'data' => $cargo], 201);
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->only(['value', 'month', 'year', 'user_id']), [
            'value' => ['required', 'number', 'max:255'],
            'month' => ['required', 'integer', 'max:255'],
            'year' => ['required', 'integer', 'max:255'],
            'user_id' => ['required', 'integer', 'max:255'],
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'data' => $validator->errors()], 400);
        }

        $dizimo = Dizimo::find($request->id);
        $dizimo->value = $request->value;
        $dizimo->month = $request->month;
        $dizimo->year = $request->year;
        $dizimo->user_id = $request->user_id;
        $dizimo->save();

        return Response::json(['status' =>'success', 'data' => $dizimo], 200);
    }

    public function delete(Request $request)
    {
        $dizimo = Dizimo::find($request->id);
        $dizimo->delete();
        return Response::json(['status' =>'success', 'data' => $dizimo], 204);
    }
}
