<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Problem;
use Validator;

class ProblemController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Problem::all()
        ], 200);
    }

    public function getDataById($id)
    {
        $problem = Problem::find($id);

        if($problem) {
            return response()->json([
                'status' => 'OK',
                'data' => $problem
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByName($name)
    {
        $problem = Problem::where('nama_problem', $name)->first();

        if($problem) {
            return response()->json([
                'status' => 'OK',
                'data' => $problem
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataBasedOnKeyword($keyword)
    {
        $problem = Problem::where('nama_problem', 'LIKE', "%$keyword%")->get();

        if($problem) {
            return response()->json([
                'status' => 'OK',
                'data' => $problem
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_problem' => 'required|unique:problem'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data sudah ada'
            ], 401);
        }

        $input = $request->all();
        $problem = Problem::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $problem
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $problem = Problem::find($id);

        if($problem) {
            $input = $request->all();
            $problem->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $problem
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function delete($id)
    {
        $problem = Problem::find($id);

        if($problem) {
            $problem->delete();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil dihapus'
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }
}
