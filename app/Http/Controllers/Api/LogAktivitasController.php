<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'total_data' => LogAktivitas::all()->count(),
            'data' => LogAktivitas::with('user')->orderBy('id', 'desc')->get()
        ], 200);
    }

    public function getDataById($id) 
    {
        $log = LogAktivitas::with('user')->where('id', $id)->first();
        return response()->json([
            'status' => 'OK',
            'data' => $log
        ], 200);
    }

    public function getAllDataByUserId($user_id)
    {
        $log = LogAktivitas::with('user')->where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 'OK',
            'total_data' => count($log),
            'data' => $log
        ], 200);
    }

    public function getOneDayDataByUserId($user_id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date("Y-m-d");
        $todayFrom = "$now 00:00:00";
        $todayTo = "$now 23:59:59";

        $log = LogAktivitas::with('user')->where('user_id', $user_id)
                                        ->whereBetween('created_at', [$todayFrom, $todayTo])
                                        ->orderBy('id', 'desc')
                                        ->get();

        return response()->json([
            'status' => 'OK',
            'total_data' => count($log),
            'data' => $log
        ], 200);
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $log = LogAktivitas::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $log
        ], 200);
    }
}