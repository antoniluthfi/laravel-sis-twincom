<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPembelianBarangSecond;

class PengajuanPembelianBarangSecondController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => PengajuanPembelianBarangSecond::with('penerimaan', 'pengerjaan', 'pengecek')->get()
        ], 200);
    }

    public function getDataByNoService($no_service)
    {
        $pengajuan = PengajuanPembelianBarangSecond::with('penerimaan', 'pengerjaan', 'pengecek')->where('no_service', $no_service)->first();

        return response()->json([
            'status' => 'OK',
            'data' => $pengajuan
        ], 200);
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $pengajuan = PengajuanPembelianBarangSecond::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $pengajuan
        ], 200);
    }

    public function update(Request $request, $no_service)
    {
        $pengajuan = PengajuanPembelianBarangSecond::where('no_service', $no_service)->first();
        $input = $request->all();
        $pengajuan->fill($input)->save();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $pengajuan
        ], 200);
    }

    public function delete($no_service)
    {
        $pengajuan = PengajuanPembelianBarangSecond::where('no_service', $no_service)->first();
        $pengajuan->delete();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus'
        ], 200);
    }
}
