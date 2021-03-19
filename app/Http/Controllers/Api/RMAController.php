<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RMA;

class RMAController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => RMA::all()
        ], 200);
    }

    public function getById($id)
    {
        $rma = RMA::find($id);

        return response()->json([
            'status' => 'OK',
            'data' => $rma
        ], 200);
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $rma = RMA::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $rma
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $rma = RMA::find($id);
        $rma->fill($input)->save();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil diupdate',
            'data' => $rma
        ], 200);
    }

    public function delete($id)
    {
        $rma = RMA::find($id);
        $rma->delete();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus',
            'data' => $rma
        ], 200);
    }
}
