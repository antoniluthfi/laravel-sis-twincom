<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenerimaanPengiriman;

class PenerimaanPengirimanController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => PenerimaanPengiriman::with('suratJalan', 'penerimaan', 'partner', 'penerima')->get()
        ], 200);
    }

    public function getDataById($no_surat_jalan)
    {
        $penerimaanPengiriman = PenerimaanPengiriman::with('suratJalan', 'penerimaan', 'partner', 'penerima')->where('no_surat_jalan', $no_surat_jalan)->get();
        if($penerimaanPengiriman) {
            return response()->json([
                'status' => 'OK',
                'data' => $penerimaanPengiriman
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByNoService($no_service)
    {
        $penerimaanPengiriman = PenerimaanPengiriman::with('suratJalan', 'penerimaan', 'partner', 'penerima')->where('no_service', $no_service)->get();
        if($penerimaanPengiriman) {
            return response()->json([
                'status' => 'OK',
                'data' => $penerimaanPengiriman
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
        $input = $request->all();
        $penerimaanPengiriman = PenerimaanPengiriman::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $penerimaanPengiriman
        ], 200);
    }

    public function update(Request $request, $no_surat_jalan, $no_service)
    {
        $penerimaanPengiriman = PenerimaanPengiriman::where(['no_surat_jalan' => $no_surat_jalan, 'no_service' => $no_service])->first();
        if($penerimaanPengiriman) {
            $input = $request->all();
            $penerimaanPengiriman->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $penerimaanPengiriman
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function delete($no_surat_jalan, $no_service)
    {
        $penerimaanPengiriman = PenerimaanPengiriman::where(['no_surat_jalan' => $no_surat_jalan, 'no_service' => $no_service])->first();

        if($penerimaanPengiriman) {
            $penerimaanPengiriman->delete();

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
