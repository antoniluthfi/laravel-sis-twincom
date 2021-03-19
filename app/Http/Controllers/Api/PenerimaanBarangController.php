<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenerimaanBarang;

class PenerimaanBarangController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => PenerimaanBarang::orderBy('no_service_penerimaan', 'desc')->with('cabang', 'bj', 'admin', 'customer', 'teknisi', 'pengajuan', 'pengerjaan', 'arusKas')->get()
        ], 200);
    }

    public function getDataById($no_service_penerimaan)
    {
        $penerimaan = PenerimaanBarang::with('cabang', 'bj', 'admin', 'customer', 'teknisi', 'pengajuan', 'pengerjaan')->where('no_service_penerimaan', $no_service_penerimaan)->first();
        return response()->json([
            'status' => 'OK',
            'data' => $penerimaan
        ], 200);
    }

    public function getDataByIdAdmin($id_admin)
    {
        $penerimaan = PenerimaanBarang::orderBy('no_service_penerimaan', 'desc')->with('cabang', 'bj', 'admin', 'customer', 'teknisi', 'pengajuan', 'pengerjaan')->where('id_admin', $id_admin)->get();
        return response()->json([
            'status' => 'OK',
            'data' => $penerimaan
        ], 200);
    }

    public function getDataByIdCabang($id_cabang)
    {
        $penerimaan = PenerimaanBarang::orderBy('no_service_penerimaan', 'desc')->with('cabang', 'bj', 'admin', 'customer', 'teknisi', 'pengajuan', 'pengerjaan', 'arusKas')->where('id_cabang', $id_cabang)->get();
        return response()->json([
            'status' => 'OK',
            'data' => $penerimaan
        ], 200);
    }

    public function getDataByIdCustomer($id_customer)
    {
        $penerimaan = PenerimaanBarang::orderBy('no_service_penerimaan', 'desc')->with('cabang', 'bj', 'admin', 'customer', 'teknisi', 'pengajuan', 'pengerjaan')->where('id_customer', $id_customer)->get();
        return response()->json([
            'status' => 'OK',
            'data' => $penerimaan
        ], 200);
    }

    public function create(Request $request)
    {
        if(strpos($request->estimasi, " - ")) {
            $sampai = explode(" - ", $request->estimasi);
            $sampai = explode(" ", $sampai[1]);
            $keterangan_waktu = $sampai[1];
            $sampai = $sampai[0];    
        } else {
            $sampai = $request->estimasi;
            $sampai = explode(" ", $sampai);
            $keterangan_waktu = $sampai[1];
            $sampai = $sampai[0];    
        }

        if($keterangan_waktu === 'Menit') {
            $time = "$sampai minute";
        } elseif($keterangan_waktu === 'Jam') {
            $time = "$sampai hours";
        } elseif($keterangan_waktu === 'Hari') {
            $time = "$sampai days";
        } elseif($keterangan_waktu === 'Minggu') {
            $time = "$sampai weeks";
        } elseif($keterangan_waktu === 'Bulan') {
            $time = "$sampai months";
        }

        date_default_timezone_set('Asia/Jakarta');
        $now = date("Y-m-d H:i:s");
        $tempo = date("Y-m-d H:i:s", strtotime($time, strtotime($now)));

        $input = $request->all();
        $input['tempo'] = $tempo;
        $penerimaan = PenerimaanBarang::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $penerimaan
        ], 200);
    }

    public function update(Request $request, $no_service_penerimaan)
    {
        $penerimaan = PenerimaanBarang::with('cabang')->where('no_service_penerimaan', $no_service_penerimaan)->first();
        $input = $request->all();
        $penerimaan->fill($input)->save();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $penerimaan
        ], 200);
    }

    public function uploadVideo(Request $request, $no_service_penerimaan) 
    {
        $penerimaan = PenerimaanBarang::where('no_service_penerimaan', $no_service_penerimaan)->first();
        $input = [];
        $input['link_video'] = $request->file->getClientOriginalName();
        $penerimaan->fill($input)->save();

        $request->file->move(public_path('video'), $request->file->getClientOriginalName());

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $request->file
        ], 200);
    }

    public function delete($no_service_penerimaan)
    {
        $penerimaan = PenerimaanBarang::where('no_service_penerimaan', $no_service_penerimaan)->first();
        $penerimaan->delete();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus'
        ], 200);
    }
}
