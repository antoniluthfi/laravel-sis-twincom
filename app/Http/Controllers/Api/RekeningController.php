<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rekening;

class RekeningController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Rekening::all()
        ], 200);
    }

    public function getDataById($id)
    {
        $rekening = Rekening::find($id);

        if($rekening) {
            return response()->json([
                'status' => 'OK',
                'data' => $rekening
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
        $rekening = Rekening::where('nama_rekening', $name)->first();

        if($rekening) {
            return response()->json([
                'status' => 'OK',
                'data' => $rekening
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
        $rekening = Rekening::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $rekening
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $rekening = Rekening::find($id);

        if($rekening) {
            $input = $request->all();
            $rekening->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $rekening
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
        $rekening = Rekening::find($id);

        if($rekening) {
            $rekening->delete();

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
