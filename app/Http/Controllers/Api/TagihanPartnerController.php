<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TagihanPartner;

class TagihanPartnerController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => TagihanPartner::with('penerimaan', 'partner')->get()
        ], 200);
    }

    public function getDataById($no_service)
    {
        $tagihanPartner = TagihanPartner::where('no_service', $no_service)->first();

        if($tagihanPartner) {
            return response()->json([
                'status' => 'OK',
                'data' => $tagihanPartner
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
        $tagihanPartner = TagihanPartner::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $tagihanPartner
        ], 200);
    }

    public function update(Request $request, $no_service)
    {
        $tagihanPartner = TagihanPartner::where('no_service', $no_service)->first();

        if($tagihanPartner) {
            $input = $request->all();
            $tagihanPartner->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $tagihanPartner
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
        $tagihanPartner = TagihanPartner::where('no_service', $no_service)->first();

        if($tagihanPartner) {
            $tagihanPartner->delete();

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
