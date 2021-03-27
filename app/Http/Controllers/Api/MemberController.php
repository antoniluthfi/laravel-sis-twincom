<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Member::with('user')->get()
        ], 200);
    }

    public function getDataById($id)
    {
        $member = Member::with('user')->where('user_id', $id)->first();

        return response()->json([
            'status' => 'OK',
            'data' => $member
        ], 200);
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $member = Member::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dibuat',
            'data' => $member
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $member = Member::where('user_id', $id)->first();
        $member->fill($input)->save();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $member
        ], 200);
    }

    public function delete($id)
    {
        $member = Member::where('user_id', $id)->first();
        $member->delete();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus'
        ], 200);
    }
}