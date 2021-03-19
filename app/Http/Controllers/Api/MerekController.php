<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merek;
use Validator;

class MerekController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Merek::all()
        ], 200);
    }

    public function getDataById($id)
    {
        $merek = Merek::find($id);

        if($merek) {
            return response()->json([
                'status' => 'OK',
                'data' => $merek
            ], 200);
        } else {
            return response()->json([
                'status' => 'OK',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByName($name)
    {
        $merek = Merek::where('merek', $name)->first();

        if($merek) {
            return response()->json([
                'status' => 'OK',
                'data' => $merek
            ], 200);
        } else {
            return response()->json([
                'status' => 'OK',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByKategori($kategori)
    {
        $merek = Merek::where(strtolower($kategori), '1')->get();

        if($merek) {
            return response()->json([
                'status' => 'OK',
                'data' => $merek
            ], 200);
        } else {
            return response()->json([
                'status' => 'OK',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required|unique:merek'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data sudah ada'
            ], 401);
        }

        $input = $request->all();
        $merek = Merek::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $merek
        ], 200);
    }

    public function update(Request $request, $id)
    {   
        $merek = Merek::find($id);

        if($merek) {
            $input = $request->all();
            $merek->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $merek
            ], 200);
        } else {
            return response()->json([
                'status' => 'OK',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function delete($id)
    {
        $merek = Merek::find($id);

        if($merek) {
            $merek->delete();
            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil dihapus',
            ], 200);    
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found',
            ], 404);    
        }
    }
}
