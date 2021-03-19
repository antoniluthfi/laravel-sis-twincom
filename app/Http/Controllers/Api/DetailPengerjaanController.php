<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailPengerjaan;

class DetailPengerjaanController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => DetailPengerjaan::all()
        ], 200);
    }

    public function create(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date("Y-m-d H:i:s");

        $input = $request->all();
        $input['waktu_mulai'] = $now;
        $detailPengerjaan = DetailPengerjaan::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $detailPengerjaan
        ], 200);
    }

    public function update(Request $request, $no_pengerjaan)
    {
        $detailPengerjaan = DetailPengerjaan::where('no_pengerjaan', $no_pengerjaan)->first();
        if($request->waktu_selesai === 'selesai') {
            date_default_timezone_set('Asia/Jakarta');
            $now = date("Y-m-d H:i:s");
        } else {
            $now = 0;
        }

        if($detailPengerjaan) {
            $input = $request->all();
            $input['waktu_selesai'] = $now;
            $detailPengerjaan->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $detailPengerjaan
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function delete($no_pengerjaan)
    {
        $detailPengerjaan = DetailPengerjaan::where('no_pengerjaan', $no_pengerjaan)->first();

        if($detailPengerjaan) {
            $detailPengerjaan->delete();
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
