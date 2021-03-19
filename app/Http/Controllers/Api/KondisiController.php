<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kondisi;
use Validator;

class KondisiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Kondisi::all()
        ], 200);
    }

    public function getDataById($id)
    {
        $kondisi = Kondisi::find($id);

        if($kondisi) {
            return response()->json([
                'status' => 'OK',
                'data' => $kondisi
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
        $kondisi = Kondisi::where('nama_kondisi', $name)->first();

        if($kondisi) {
            return response()->json([
                'status' => 'OK',
                'data' => $kondisi
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
        $kondisi = Kondisi::where('nama_kondisi', 'LIKE', "%$keyword%")->get();

        if($kondisi) {
            return response()->json([
                'status' => 'OK',
                'data' => $kondisi
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
            'nama_kondisi' => 'required|unique:kondisi'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data sudah ada'
            ], 401);
        }

        $input = $request->all();
        $kondisi = Kondisi::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $kondisi
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $kondisi = Kondisi::find($id);

        if($kondisi) {
            $input = $request->all();
            $kondisi->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $kondisi
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
        $kondisi = Kondisi::find($id);

        if($kondisi) {
            $kondisi->delete();

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
