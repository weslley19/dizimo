<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MembersController extends Controller
{
    public function index()
    {
        $members = Member::with('cargo')->get();
        return Response::json(['status' => 'success', 'data' => $members], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->only(['name', 'cargo_id']), [
            'name' => ['required', 'string', 'max:255'],
            'cargo_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $member = Member::create($validator->validated());
        return Response::json(['status' =>'success', 'data' => $member], 201);
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->only(['name', 'cargo_id']), [
            'name' => ['required', 'string', 'max:255'],
            'cargo_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $member = Member::find($request->id);
        $member->name = $request->name;
        $member->cargo_id = $request->cargo_id;
        $member->save();

        return Response::json(['status' =>'success', 'data' => $member], 200);
    }

    public function delete(Request $request)
    {
        $member = Member::find($request->id);
        $member->delete();
        return Response::json(['status' =>'success', 'data' => $member], 200);
    }
}
