<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Pembayaran::with('penerimaan', 'arusKas', 'admin', 'pengerjaan')->get()
        ], 200);
    }

    public function getDataById($no_pembayaran)
    {
        $pembayaran = Pembayaran::with('penerimaan', 'arusKas', 'admin', 'pengerjaan', 'teknisi')->where('no_pembayaran', $no_pembayaran)->first();

        if($pembayaran) {
            return response()->json([
                'status' => 'OK',
                'data' => $pembayaran
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
        $pembayaran = Pembayaran::with('penerimaan', 'arusKas', 'admin', 'pengerjaan', 'teknisi')->where('no_service', $no_service)->first();

        if($pembayaran) {
            return response()->json([
                'status' => 'OK',
                'data' => $pembayaran
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
        $pembayaran = Pembayaran::with('penerimaan', 'arusKas', 'admin', 'pengerjaan', 'teknisi')->where('cabang', $cabang)->get();

        if($pembayaran) {
            return response()->json([
                'status' => 'OK',
                'data' => $pembayaran
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
        $pembayaran = Pembayaran::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $pembayaran
        ], 200);
    }

    public function update(Request $request, $no_pembayaran)
    {
        $pembayaran = Pembayaran::where('no_pembayaran', $no_pembayaran)->first();

        if($pembayaran) {
            $input = $request->all();
            $pembayaran->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $pembayaran 
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function delete($no_pembayaran)
    {
        $pembayaran = Pembayaran::where('no_pembayaran', $no_pembayaran)->get();

        if($pembayaran) {
            if(gettype($pembayaran['no_pembayaran']) === 'array') {
                for ($i=0; $i < count($pembayaran['no_pembayaran']); $i++) { 
                    $pembayaran[$i]->delete();
                }
            } else {
                $pembayaran->delete();
            }

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
