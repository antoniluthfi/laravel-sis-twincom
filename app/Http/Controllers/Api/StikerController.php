<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stiker;

class StikerController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Stiker::all()
        ], 200);
    }

    public function getDataById($id)
    {
        $stiker = Stiker::find($id);

        if($stiker) {
            return response()->json([
                'status' => 'OK',
                'data' => $stiker
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
        $stiker = Stiker::where('jenis_stiker', $name)->first();

        if($stiker) {
            return response()->json([
                'status' => 'OK',
                'data' => $stiker
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
        $stiker = Stiker::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $stiker
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $stiker = Stiker::find($id);

        if($stiker) {
            $input = $request->all();
            $stiker->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $stiker
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
        $stiker = Stiker::find($id);

        if($stiker) {
            $stiker->delete();

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
