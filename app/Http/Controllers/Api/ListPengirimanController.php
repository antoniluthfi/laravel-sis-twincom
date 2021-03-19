<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ListPengiriman;

class ListPengirimanController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => ListPengiriman::with('penerimaan', 'suratJalan', 'tagihanPartner')->get()
        ], 200);
    }

    public function getDataById($no_surat_jalan)
    {
        $list = ListPengiriman::with('penerimaan', 'suratJalan', 'tagihanPartner')->where('no_surat_jalan', $no_surat_jalan)->get();
        return response()->json([
            'status' => 'OK',
            'data' => $list
        ], 200);
    }

    public function getDataByNoService($no_service)
    {
        $list = ListPengiriman::with('penerimaan', 'suratJalan', 'tagihanPartner')->where('no_service', $no_service)->get();
        return response()->json([
            'status' => 'OK',
            'data' => $list
        ], 200);
    }

    public function create(Request $request)
    {
        $payload = $request->payload;
        for ($i = 0; $i < count($payload); $i++) { 
            $input = [];
            $input['no_surat_jalan'] = $request->no_surat_jalan;

            $input['no_service'] = $payload[$i]['no_service'];
            $input['kelengkapan'] = implode(",", $payload[$i]['kelengkapan']);
            $input['kerusakan'] = $payload[$i]['kerusakan'];
            $input['status_pengiriman'] = 0;

            $list = ListPengiriman::create($input);
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $request
        ], 200);
    }

    public function update(Request $request, $no_surat_jalan)
    {
        $pengiriman = ListPengiriman::where('no_surat_jalan', $no_surat_jalan);
        for ($i = 0; $i < count($pengiriman); $i++) { 
            $pengiriman[$i]->delete();
        }

        $payload = $request->payload;
        for ($i = 0; $i < count($payload); $i++) { 
            $input = [];
            $input['no_surat_jalan'] = $request->no_surat_jalan;

            $input['no_service'] = $payload[$i]['no_service'];
            $input['kelengkapan'] = implode(",", $payload[$i]['kelengkapan']);
            $input['kerusakan'] = $payload[$i]['kerusakan'];
            $input['status_pengiriman'] = 0;

            $list = ListPengiriman::create($input);
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $list
        ], 200);
    }

    public function updateByNoService(Request $request, $no_service)
    {
        $barang = ListPengiriman::where('no_service', $no_service)->first();
        $input = $request->all();

        $barang->fill($input)->save();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $barang
        ], 200);
    }

    public function delete($no_service)
    {
        $list = ListPengiriman::where('no_service', $no_service)->get();
        for ($i = 0; $i < count($list); $i++) { 
            $list[$i]->delete();
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
