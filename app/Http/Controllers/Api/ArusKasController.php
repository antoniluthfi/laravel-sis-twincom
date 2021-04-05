<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ArusKas;
use App\Models\SandiTransaksi;

class ArusKasController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => ArusKas::with('penerimaan', 'pembayaran', 'pengembalian', 'admin', 'transaksi')->get()
        ], 200);
    }

    public function getDataById($no_bukti)
    {
        $arusKas = ArusKas::with('penerimaan', 'pembayaran', 'pengembalian', 'admin', 'transaksi')->where('no_bukti', $no_bukti)->first();

        return response()->json([
            'status' => 'OK',
            'data' => $arusKas
        ], 200);
    }

    public function getDataByIdAdmin($id_admin)
    {
        $arusKas = ArusKas::with('penerimaan', 'pembayaran', 'pengembalian', 'admin', 'transaksi')->where('id_admin', $id_admin)->get();

        return response()->json([
            'status' => 'OK',
            'data' => $arusKas
        ], 200);
    }

    public function getDataByNoService($no_service)
    {
        $arusKas = ArusKas::with('penerimaan', 'pembayaran', 'pengembalian', 'admin', 'transaksi')->where('no_service', $no_service)->first();

        return response()->json([
            'status' => 'OK',
            'data' => $arusKas
        ], 200);
    }

    public function getDataByNoPembayaran($no_pembayaran)
    {
        $arusKas = ArusKas::with('penerimaan', 'pembayaran', 'pengembalian', 'admin', 'transaksi')->where('no_pembayaran', $no_pembayaran)->first();

        return response()->json([
            'status' => 'OK',
            'data' => $arusKas
        ], 200);
    }

    public function getDataByNoPengembalian($no_pengembalian)
    {
        $arusKas = ArusKas::with('penerimaan', 'pembayaran', 'pengembalian', 'admin', 'transaksi')->where('no_pengembalian', $no_pengembalian)->first();

        return response()->json([
            'status' => 'OK',
            'data' => $arusKas
        ], 200);
    }

    public function getLaporan($cabang)
    {
        if($cabang === 'all') {
            $arusKas = DB::select("SELECT 
            (SELECT SUM(nominal) FROM arus_kas WHERE masuk = 1) AS pemasukan, 
            (SELECT SUM(nominal) FROM arus_kas WHERE keluar = 1) AS pengeluaran, cabang FROM `arus_kas` 
            GROUP BY cabang");
        } else {
            $arusKas = DB::select("SELECT 
            (SELECT SUM(nominal) FROM arus_kas WHERE masuk = 1) AS pemasukan, 
            (SELECT SUM(nominal) FROM arus_kas WHERE keluar = 1) AS pengeluaran, no_service, cabang FROM `arus_kas` 
            GROUP BY cabang HAVING cabang = '$cabang'");
        }

        return response()->json([
            'status' => 'OK',
            'data' => $arusKas
        ], 200);
    }

    public function create(Request $request)
    {
        $sandiTransaksi = SandiTransaksi::where('id', $request->id_sandi)->first();

        if($sandiTransaksi['jenis_transaksi'] == '0') {
            $masuk = 0;
            $keluar = 1;
        } else {
            $masuk = 1;
            $keluar = 0;
        }

        $input = $request->all();
        $input['masuk'] = $masuk;
        $input['keluar'] = $keluar;
        $input['keterangan'] = $sandiTransaksi['sandi_transaksi'] . ' ' . $request->keterangan;
        $arusKas = ArusKas::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $arusKas
        ], 200);
    }

    public function update(Request $request, $no_bukti)
    {
        $sandiTransaksi = SandiTransaksi::where('id', $request->id_sandi)->first();

        if($sandiTransaksi['jenis_transaksi'] == '0') {
            $masuk = 0;
            $keluar = 1;
        } else {
            $masuk = 1;
            $keluar = 0;
        }

        $arusKas = ArusKas::where('no_bukti', $no_bukti)->first();
        $input = $request->all();
        $input['masuk'] = $masuk;
        $input['keluar'] = $keluar;
        $input['keterangan'] = $sandiTransaksi['sandi_transaksi'] . ' ' . $request->keterangan;    
        $arusKas->fill($input)->save();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $arusKas
        ], 200);
    }

    public function delete($no_bukti)
    {
        $arusKas = ArusKas::where('no_bukti', $no_bukti)->first();
        $arusKas->delete();
        
        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus',
        ], 200);
    }

    public function deleteForPengembalian($no_pengembalian)
    {
        $arusKas = ArusKas::where('no_pengembalian', $no_pengembalian)->get();
        for ($i = 0; $i < count($arusKas); $i++) { 
            $arusKas[$i]->delete();
        }
        
        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus',
        ], 200);
    }

    public function deleteForPembayaran($no_pembayaran)
    {
        $arusKas = ArusKas::where('no_pembayaran', $no_pembayaran)->get();
        for ($i = 0; $i < count($arusKas); $i++) { 
            $arusKas[$i]->delete();
        }
        
        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
