<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OneSignal;

class OneSignalController extends Controller
{
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
