<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangJasa;
use Validator;

class BarangJasaController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => BarangJasa::all()
        ], 200);
    }

    public function getDataById($id)    
    {
        $bj = BarangJasa::find($id);
        if($bj) {
            return response()->json([
                'status' => 'OK',
                'data' => $bj
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
        $bj = BarangJasa::where('nama_bj', $name)->first();
        if($bj) {
            return response()->json([
                'status' => 'OK',
                'data' => $bj
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByJenis($jenis)    
    {
        $bj = BarangJasa::where('jenis', $jenis)->get();
        if($bj) {
            return response()->json([
                'status' => 'OK',
                'data' => $bj
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
            'nama_bj' => 'required|unique:barang_jasa'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data sudah ada'
            ], 401);
        }

        $input = $request->all();
        $bj = BarangJasa::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $bj
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $bj = BarangJasa::find($id);

        if($bj) {
            $input = $request->all();
            $bj->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $bj
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
        $bj = BarangJasa::find($id);

        if($bj) {
            $bj->delete();
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
