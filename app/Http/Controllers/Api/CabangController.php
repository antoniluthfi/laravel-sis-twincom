<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cabang;
use Validator;

class CabangController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Cabang::all()
        ], 200);
    }

    public function getDataById($id)
    {
        $cabang = Cabang::find($id);

        if($cabang) {
            return response()->json([
                'status' => 'OK',
                'data' => $cabang
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
        $cabang = Cabang::where('nama_cabang', $name)->first();

        if($cabang) {
            return response()->json([
                'status' => 'OK',
                'data' => $cabang
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
            'nama_cabang' => 'required|unique:cabang'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data sudah ada'
            ], 401);
        }

        $input = $request->all();
        $cabang = Cabang::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $cabang
        ], 200);
    } 

    public function update(Request $request, $id) 
    {
        $cabang = Cabang::find($id);

        if($cabang) {
            $input = $request->all();
            $cabang->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $cabang
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
        $cabang = Cabang::find($id);

        if($cabang) {
            $cabang->delete();

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
