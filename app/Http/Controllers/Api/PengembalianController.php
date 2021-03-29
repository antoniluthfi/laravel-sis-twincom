<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\ArusKas;

class PengembalianController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Pengembalian::with('penerimaan', 'admin', 'pj', 'pengerjaan')->get()
        ], 200);
    }

    public function getDataById($no_pengembalian)
    {
        $pengembalian = Pengembalian::with('penerimaan', 'admin', 'pj', 'pengerjaan')->where('no_pengembalian', $no_pengembalian)->first();
        if($pengembalian) {
            return response()->json([
                'status' => 'OK',
                'data' => $pengembalian
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByCabang($cabang)
    {
        $pengembalian = Pengembalian::with('penerimaan', 'admin', 'pj', 'pengerjaan')->where('cabang', $cabang)->get();
        if($pengembalian) {
            return response()->json([
                'status' => 'OK',
                'data' => $pengembalian
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
        $pengembalian = Pengembalian::with('penerimaan', 'admin', 'pj', 'pengerjaan')->where('no_service', $no_service)->first();
        if($pengembalian) {
            return response()->json([
                'status' => 'OK',
                'data' => $pengembalian
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
        $pengembalian = Pengembalian::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $pengembalian
        ], 200);
    }

    public function update(Request $request, $no_pengembalian)
    {
        $pengembalian = Pengembalian::where('no_pengembalian', $no_pengembalian)->first();
        if($pengembalian) {
            $input = $request->all();
            $pengembalian->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $pengembalian
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function delete($no_pengembalian)
    {
        $pengembalian = Pengembalian::where('no_pengembalian', $no_pengembalian)->first();

        if($pengembalian) {
            $pengembalian->delete();

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

    public function deleteByNoService($no_service)
    {
        $pengembalian = Pengembalian::where('no_service', $no_service)->get();
        for ($i = 0; $i < count($pengembalian); $i++) { 
            $pengembalian[$i]->delete();
        }

        if($pengembalian) {
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
