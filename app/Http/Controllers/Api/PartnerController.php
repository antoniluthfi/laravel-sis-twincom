<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use Validator;

class PartnerController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Partner::all()
        ], 200);
    }

    public function getDataById($id)
    {
        $partner = Partner::find($id);

        if($partner) {
            return response()->json([
                'status' => 'OK',
                'data' => $partner
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByName($name)
    {
        $partner = Partner::where('nama', $name)->first();

        if($partner) {
            return response()->json([
                'status' => 'OK',
                'data' => $partner
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
        $validator = Validator::make($request->all(), [
            'nama' => 'required|nama|unique:partner',
            'email' => 'required|email|unique:partner',
            'nomorhp' => 'required|nomorhp|unique:partner',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data sudah ada'
            ], 401);
        }

        $input = $request->all();
        $partner = Partner::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $partner
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::find($id);

        if($partner) {
            $input = $request->all();
            $partner->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $partner
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found',
                'data' => $partner
            ], 404);
        }
    }

    public function delete($id)
    {
        $partner = Partner::find($id);

        if($partner) {
            $partner->delete();

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
