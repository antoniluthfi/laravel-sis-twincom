<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SandiTransaksi;
use Validator;

class SandiTransaksiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => SandiTransaksi::all()
        ], 200);
    }

    public function getDataById($id)
    {
        $sandiTransaksi = SandiTransaksi::find($id);

        if($sandiTransaksi) {
            return response()->json([
                'status' => 'OK',
                'data' => $sandiTransaksi
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
        $sandiTransaksi = SandiTransaksi::where('sandi_transaksi', $name)->first();

        if($sandiTransaksi) {
            return response()->json([
                'status' => 'OK',
                'data' => $sandiTransaksi
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataForPengembalian()
    {
        $sandiTransaksi = SandiTransaksi::where('sandi_transaksi', 'Penerimaan DP Biaya Service')
                                        ->orWhere('sandi_transaksi', 'Penerimaan Biaya Service')
                                        ->get();
    
        if($sandiTransaksi) {
            return response()->json([
                'status' => 'OK',
                'data' => $sandiTransaksi
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
            'sandi_transaksi' => 'required|unique:sandi_transaksi'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data sudah ada'
            ], 401);
        }
        
        $input = $request->all();
        $sandiTransaksi = SandiTransaksi::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $sandiTransaksi
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $sandiTransaksi = SandiTransaksi::find($id);

        if($sandiTransaksi) {
            $input = $request->all();
            $sandiTransaksi->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $sandiTransaksi
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
        $sandiTransaksi = SandiTransaksi::find($id);

        if($sandiTransaksi) {
            $sandiTransaksi->delete();

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
