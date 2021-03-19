<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tipe;
use Validator;

class TipeController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Tipe::all()
        ], 200);
    }

    public function getDataById($id)
    {
        $tipe = Tipe::find($id);

        if($tipe) {
            return response()->json([
                'status' => 'OK',
                'data' => $tipe
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
        $tipe = Tipe::where('tipe', $name)->first();

        if($tipe) {
            return response()->json([
                'status' => 'OK',
                'data' => $tipe
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByMerek($merek)
    {
        $tipe = Tipe::where('merek', $merek)->get();

        if($tipe) {
            return response()->json([
                'status' => 'OK',
                'data' => $tipe
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
            'tipe' => 'required|unique:tipe'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data sudah ada'
            ], 401);
        }

        $input = $request->all();
        $tipe = Tipe::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $tipe
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $tipe = Tipe::find($id);

        if($tipe) {
            $input = $request->all();
            $tipe->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'massage' => 'Data berhasil diupdate',
                'data' => $tipe
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
        $tipe = Tipe::find($id);

        if($tipe) {
            $tipe->delete();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil dihapus'
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found',
            ], 404);
        }
    }
}
