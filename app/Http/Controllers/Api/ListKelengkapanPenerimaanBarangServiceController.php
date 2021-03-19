<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ListKelengkapanPenerimaanBarangService;

class ListKelengkapanPenerimaanBarangServiceController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => ListKelengkapanPenerimaanBarangService::all()
        ], 200);
    }

    public function getDataByNoService($no_service)
    {
        $kelengkapan = ListKelengkapanPenerimaanBarangService::where('no_service', $no_service)->get();

        return response()->json([
            'status' => 'OK',
            'data' => $kelengkapan
        ], 200);
    }

    public function create(Request $request)
    {
        if(strpos($request->kelengkapan, ',')) {
            $kelengkapan = explode(',', $request->kelengkapan);
        } else {
            $kelengkapan = [0 => $request->kelengkapan];
        }

        for ($i = 0; $i < count($kelengkapan); $i++) { 
            $input = $request->all();
            $input['kelengkapan'] = $kelengkapan[$i];

            $list = ListKelengkapanPenerimaanBarangService::create($input);
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $list
        ], 200);
    }

    public function update(Request $request, $no_service)
    {
        $list = ListKelengkapanPenerimaanBarangService::where('no_service', $no_service)->get();
        for ($i = 0; $i < count($list); $i++) { 
            $list[$i]->delete();
        }

        if(strpos($request->kelengkapan, ',')) {
            $kelengkapan = explode(',', $request->kelengkapan);
        } else {
            $kelengkapan = [0 => $request->kelengkapan];
        }

        for ($i = 0; $i < count($kelengkapan); $i++) { 
            $input = $request->all();
            $input['kelengkapan'] = $kelengkapan[$i];

            $list = ListKelengkapanPenerimaanBarangService::create($input);
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $list
        ], 200);
    }

    public function delete($no_service)
    {
        $list = ListKelengkapanPenerimaanBarangService::where('no_service', $no_service)->get();
        for ($i = 0; $i < count($list); $i++) { 
            $list[$i]->delete();
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
