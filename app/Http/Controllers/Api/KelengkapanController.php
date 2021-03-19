<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelengkapan;
use Validator;

class KelengkapanController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Kelengkapan::all()
        ], 200);
    }

    public function getDataById($id)
    {
        $kelengkapan = Kelengkapan::find($id);

        if($kelengkapan) {
            return response()->json([
                'status' => 'OK',
                'data' => $kelengkapan
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
        $kelengkapan = Kelengkapan::where('nama_kelengkapan', $name)->first();

        if($kelengkapan) {
            return response()->json([
                'status' => 'OK',
                'data' => $kelengkapan
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
        $kelengkapan = Kelengkapan::where('nama_kelengkapan', 'LIKE', "%$keyword%")->get();

        if($kelengkapan) {
            return response()->json([
                'status' => 'OK',
                'data' => $kelengkapan
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
            'nama_kelengkapan' => 'required|unique:kelengkapan'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data sudah ada'
            ], 401);
        }

        $input = $request->all();
        $kelengkapan = Kelengkapan::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $kelengkapan
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $kelengkapan = Kelengkapan::find($id);

        if($kelengkapan) {
            $input = $request->all();
            $kelengkapan->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $kelengkapan
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
        $kelengkapan = Kelengkapan::find($id);

        if($kelengkapan) {
            $kelengkapan->delete();

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
