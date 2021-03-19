<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notifikasi;
use App\Models\User;

class NotifikasiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'total_data' => Notifikasi::with('user')->count(),
            'data' => Notifikasi::with('user')->limit(5)->get()
        ], 200);
    }

    public function getDataByUserId($role, $id)
    {
        if($role === 'teknisi') {
            $notifikasi = DB::select("SELECT 
                    notifikasi.id, notifikasi.user_id, notifikasi.hak_akses, notifikasi.keterangan, notifikasi.created_at, 
                    users.name, users.cab_penempatan, users.created_at AS terdaftar, teknisi_pj.id_teknisi, 
                (SELECT COUNT(pengerjaan.status_pengerjaan) FROM pengerjaan) AS total_pendingan, 
                (SELECT COUNT(pengerjaan.status_pengerjaan) FROM pengerjaan WHERE pengerjaan.status_pengerjaan = 0) AS belum_dikerjakan, 
                (SELECT COUNT(pengerjaan.status_pengerjaan) FROM pengerjaan WHERE pengerjaan.status_pengerjaan = 1) AS cancel, 
                (SELECT COUNT(pengerjaan.status_pengerjaan) FROM pengerjaan WHERE pengerjaan.status_pengerjaan = 2) AS sedang_dikerjakan, 
                (SELECT COUNT(pengerjaan.status_pengerjaan) FROM pengerjaan WHERE pengerjaan.status_pengerjaan = 3) AS selesai FROM `notifikasi` 
                LEFT JOIN users ON notifikasi.user_id = users.id 
                LEFT JOIN teknisi_pj ON notifikasi.user_id = teknisi_pj.id_teknisi 
                LEFT JOIN pengerjaan ON teknisi_pj.no_service = pengerjaan.no_service GROUP BY notifikasi.user_id"
            );
            return response()->json([
                'status' => 'OK',
                'total_data' => count(array($notifikasi)),
                'data' => $notifikasi
            ], 200);    
        } else if($role === 'customer') {
            $notifikasi = Notifikasi::with('customer')->where('user_id', $id)->get();
            return response()->json([
                'status' => 'OK',
                'total_data' => count(array($notifikasi)),
                'data' => $notifikasi
            ], 200);
        }

    }

    public function getDataByRole($role)
    {
        $notifikasi = Notifikasi::with('user')->where('hak_akses', $role)->get();

        return response()->json([
            'status' => 'OK',
            'total_data' => count($notifikasi),
            'data' => $notifikasi
        ], 200);
    }

    public function create(Request $request)
    {
        $input = $request->all();
        if($request->hak_akses === 'teknisi') {
            if(strpos($request->user_id, ',')) {
                $teknisi = explode(',', $request->user_id);
    
                for ($i = 0; $i < count($teknisi); $i++) { 
                    $id_teknisi = User::where('name', $teknisi[$i])->first();

                    $input['user_id'] = $id_teknisi['id'];
                    $notifikasi = Notifikasi::create($input);
                }
            } else {
                $notifikasi = Notifikasi::create($input);
            }
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $notifikasi
        ], 200);
    }
}
