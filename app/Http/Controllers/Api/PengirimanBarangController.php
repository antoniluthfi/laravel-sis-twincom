<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengirimanBarang;

class PengirimanBarangController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => PengirimanBarang::with('admin', 'pengirim', 'pengantar', 'partner', 'list_pengiriman')->get()
        ], 200);
    }

    public function getDataById($no_surat_jalan)
    {
        $pengiriman = PengirimanBarang::with('admin', 'pengirim', 'pengantar', 'partner', 'list_pengiriman')->where('no_surat_jalan', $no_surat_jalan)->first();
        if($pengiriman) {
            return response()->json([
                'status' => 'OK',
                'data' => $pengiriman
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByIdAdmin($id_admin)
    {
        $pengiriman = PengirimanBarang::with('admin', 'pengirim', 'pengantar', 'partner', 'list_pengiriman')->where('id_admin', $id_admin)->get();
        
        if($pengiriman) {
            return response()->json([
                'status' => 'OK',
                'data' => $pengiriman
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
        $pengiriman = PengirimanBarang::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $pengiriman
        ], 200);
    }

    public function update(Request $request, $no_surat_jalan)
    {
        $pengiriman = PengirimanBarang::where('no_surat_jalan', $no_surat_jalan)->first();
        if($pengiriman) {
            $input = $request->all();
            $pengiriman->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $pengiriman
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function delete($no_surat_jalan)
    {
        $pengiriman = PengirimanBarang::where('no_surat_jalan', $no_surat_jalan)->first();

        if($pengiriman) {
            $pengiriman->delete();

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
