<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diskon;

class DiskonController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Diskon::all()
        ], 200);
    }

    public function getDataById($id)
    {
        $diskon = Diskon::where('user_id', $id)->first();

        if($diskon) {
            return response()->json([
                'status' => 'OK',
                'data' => $diskon
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
        $diskon = Diskon::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $diskon
        ], 200);
    } 

    public function update(Request $request, $id) 
    {
        $diskon = Diskon::where('user_id', $id)->first();

        if($diskon) {
            $input = $request->all();
            $diskon->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $diskon
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function delete($id)
    {
        $diskon = Diskon::where('user_id', $id)->first();

        if($diskon) {
            $diskon->delete();

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
