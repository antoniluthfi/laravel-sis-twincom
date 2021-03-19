<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TeknisiPj;
use App\Models\User;

class TeknisiPjController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => TeknisiPj::with('penerimaan', 'pengerjaan', 'teknisi')->get()
        ], 200);
    }

    public function getDataById($no_service)
    {
        $teknisi = TeknisiPj::with('penerimaan', 'pengerjaan', 'teknisi')->where('no_service', $no_service)->get();

        if($teknisi) {
            return response()->json([
                'status' => 'OK',
                'data' => $teknisi
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByTeknisi($id_teknisi)
    {
        $teknisi = DB::select("SELECT teknisi_pj.id_teknisi, 
        (SELECT COUNT(pengerjaan.status_pengerjaan) FROM pengerjaan) AS total_pengerjaan, 
        (SELECT COUNT(pengerjaan.status_pengerjaan) FROM pengerjaan WHERE pengerjaan.status_pengerjaan = 0) AS belum_dikerjakan, 
        (SELECT COUNT(pengerjaan.status_pengerjaan) FROM pengerjaan WHERE pengerjaan.status_pengerjaan = 1) AS cancel, 
        (SELECT COUNT(pengerjaan.status_pengerjaan) FROM pengerjaan WHERE pengerjaan.status_pengerjaan = 2) AS sedang_dikerjakan, 
        (SELECT COUNT(pengerjaan.status_pengerjaan) FROM pengerjaan WHERE pengerjaan.status_pengerjaan = 3) AS selesai FROM teknisi_pj LEFT JOIN pengerjaan ON teknisi_pj.no_service = pengerjaan.no_service GROUP BY teknisi_pj.id_teknisi HAVING teknisi_pj.id_teknisi = '$id_teknisi'");

        if($teknisi) {
            return response()->json([
                'status' => 'OK',
                'data' => $teknisi[0]
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
        if(strpos($request->id_teknisi, ",")) {
            $id_teknisi = explode(",", $request->id_teknisi);
            for ($i = 0; $i < count($id_teknisi); $i++) { 
                $user = User::where('name', $id_teknisi[$i])->first();
                $user = $user['id'];

                $teknisi = new TeknisiPj;
                $teknisi->no_service = $request->no_service;
                $teknisi->id_teknisi = $user;
                $teknisi->save();
            }    
        } else {
            $user = User::where('name', $request->id_teknisi)->first();
            $id_teknisi = [0 => $user['id']];
        }
        
        for ($i = 0; $i < count($id_teknisi); $i++) { 
            $teknisi = new TeknisiPj;
            $teknisi->no_service = $request->no_service;
            $teknisi->id_teknisi = $id_teknisi[$i];
            $teknisi->save();
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $teknisi
        ], 200);
    }

    public function update(Request $request, $no_service)
    {
        $teknisi = TeknisiPj::where('no_service', $no_service)->get();

        if($teknisi) {
            $input = $request->all();
            $teknisi->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $teknisi
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function delete($no_service)
    {
        $teknisi = TeknisiPj::where('no_service', $no_service);

        if($teknisi) {
            $teknisi->delete();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }
}
