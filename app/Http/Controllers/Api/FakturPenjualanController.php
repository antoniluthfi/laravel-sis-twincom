<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FakturPenjualan;

class FakturPenjualanController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => FakturPenjualan::with('penerimaan')->get()
        ], 200);
    }

    public function getDataById($id)
    {
        $fakturPenjualan = FakturPenjualan::with('penerimaan')->where('no_faktur', $id)->first();

        return response()->json([
            'status' => 'OK',
            'data' => $fakturPenjualan
        ], 200);
    }

    public function getDataByNoService($no_service)
    {
        $fakturPenjualan = FakturPenjualan::with('penerimaan')->where('no_service', $no_service)->first();

        return response()->json([
            'status' => 'OK',
            'data' => $fakturPenjualan
        ], 200);   
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $fakturPenjualan = FakturPenjualan::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dibuat',
            'data' => $fakturPenjualan
        ], 200);
    }

    public function update(Request $request, $no_service)
    {
        $input = $request->all();
        $fakturPenjualan = FakturPenjualan::where('no_service', $no_service)->first();
        $fakturPenjualan->fill($input)->save();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $fakturPenjualan
        ], 200);
    }

    public function delete($no_service)
    {
        $fakturPenjualan = FakturPenjualan::where('no_service', $no_service)->first();
        $fakturPenjualan->delete();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
