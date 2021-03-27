<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OneSignal;

class OneSignalController extends Controller
{
    public function getDataByUserId($id)
    {
        $onesignal = OneSignal::select('player_id')->where('user_id', $id)->get();

        return response()->json([
            'status' => 'OK',
            'data' => $onesignal
        ], 200);
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $onesignal = OneSignal::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $onesignal
        ], 200);
    }
}