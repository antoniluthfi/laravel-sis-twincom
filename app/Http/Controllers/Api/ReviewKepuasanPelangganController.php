<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ReviewKepuasanPelanggan;
use App\Models\User;

class ReviewKepuasanPelangganController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => ReviewKepuasanPelanggan::get()
        ], 200);
    }

    public function getDataById($id)
    {
        $review = ReviewKepuasanPelanggan::where('no_service', $no_service)->get();
        return response()->json([
            'status' => 'OK',
            'data' => $review
        ], 200);
    }

    public function getDataByUserId($user_id) 
    {
        $review = DB::select("SELECT SUM(rating) AS sum_rate, COUNT(rating) AS total_rate, (SUM(rating) / COUNT(rating)) AS average, cabang FROM `review_kepuasan_pelanggan` GROUP BY user_id HAVING user_id = '$user_id'");

        return response()->json([
            'status' => 'OK',
            'data' => $review
        ], 200);
    }

    public function getDataByCabang($cabang)
    {
        if($cabang === 'all') {
            $review = DB::select("SELECT SUM(rating) AS sum_rate, COUNT(rating) AS total_rate, (SUM(rating) / COUNT(rating)) AS average, cabang FROM `review_kepuasan_pelanggan` GROUP BY cabang");
        } else {
            $review = DB::select("SELECT SUM(rating) AS sum_rate, COUNT(rating) AS total_rate, (SUM(rating) / COUNT(rating)) AS average, cabang FROM `review_kepuasan_pelanggan` GROUP BY cabang HAVING cabang = '$cabang'");
        }
        
        return response()->json([
            'status' => 'OK',
            'data' => $review
        ], 200);
    }

    public function create(Request $request)
    {
        if($request->penerimaan_barang && $request->penerimaan_barang == true) {
            $review = ReviewKepuasanPelanggan::where('no_service', $request->no_service)->get();
            for ($i = 0; $i < count($review); $i++) { 
                $review[$i]->delete();
            }
        }

        if(strpos($request->user_id, ",")) {
            $user_id = explode(",", $request->user_id);
            $input = $request->all();

            $a = [];
            for ($i = 0; $i < count($user_id); $i++) { 
                $user = User::select('id', 'jabatan', 'cab_penempatan')->where('name', $user_id[$i])->first();
                
                $input['user_id'] = $user['id'];
                $input['jabatan'] = $user['jabatan'];
                $input['cabang'] = $user['cab_penempatan'];
                $review = ReviewKepuasanPelanggan::create($input);
            }
        } else {
            $user = User::select('id')->where('name', $request->user_id)->first();
            $input['user_id'] = $user['id'];
            $review = ReviewKepuasanPelanggan::create($input);
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $request->user_id
        ], 200);
    }

    public function update(Request $request, $no_service)
    {
        $review = ReviewKepuasanPelanggan::where('no_service', $no_service)->get();
        for ($i = 0; $i < count($review); $i++) { 
            $review[$i]->delete();
        }

        if(strpos($request->user_id, ",")) {
            $user_id = explode(",", $request->user_id);
            $input = $request->all();

            $a = [];
            for ($i = 0; $i < count($user_id); $i++) { 
                $user = User::select('id', 'jabatan', 'cab_penempatan')->where('name', $user_id[$i])->first();
                
                $input['user_id'] = $user['id'];
                $input['jabatan'] = $user['jabatan'];
                $input['cabang'] = $user['cab_penempatan'];
                $review = ReviewKepuasanPelanggan::create($input);
            }
        } else {
            $user = User::select('id')->where('name', $user_id[$i])->first();
            $input['user_id'] = $user['id'];
            $review = ReviewKepuasanPelanggan::create($input);
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $review
        ], 200);
    }

    public function updateWithoutDelete(Request $request, $no_service)
    {
        $review = ReviewKepuasanPelanggan::where('no_service', $request->no_service)->get();
        $input = $request->all();
        for ($i = 0; $i < count($review); $i++) { 
            if($review[$i]['jabatan'] === 'admin service') {
                $input['rating'] = $request->rating_admin;
                $input['ulasan'] = $request->ulasan_admin;
            } elseif($review[$i]['jabatan'] === 'teknisi') {
                $input['rating'] = $request->rating_teknisi;
                $input['ulasan'] = $request->ulasan_teknisi;
            }

            $review[$i]->fill($input)->save();
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $review
        ], 200);
    }

    public function delete($no_service)
    {
        $review = ReviewKepuasanPelanggan::where('no_service', $no_service)->get();
        for ($i = 0; $i < count($review); $i++) { 
            $review[$i]->delete();
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
