<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Customer::with('diskon')->get()
        ], 200);
    }

    public function getDataById($id)
    {
        $customer = Customer::with('diskon')->find($id);
        if($customer) {
            return response()->json([
                'status' => 'OK',
                'data' => $customer
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
        $customer = Customer::with('diskon')->where('nama', $name)->first();
        if($customer) {
            return response()->json([
                'status' => 'OK',
                'data' => $customer
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataBasedOnKeyword($keyword)
    {
        $customer = Customer::where('nama', 'LIKE', "%$keyword%")
                            ->orWhere('email', 'LIKE', "%$keyword%")
                            ->orWhere('alamat', 'LIKE', "%$keyword%")
                            ->orWhere('nomorhp', 'LIKE', "%$keyword%")
                            ->get();
        if($customer) {
            return response()->json([
                'status' => 'OK',
                'data' => $customer
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getCurrentUser()
    {
        $id = Auth::user()->id;
        $customer = Customer::find($id);

        return response()->json([
            'status' => 'OK',
            'data' => $customer
        ], 200);
    }

    public function create(Request $request)
    {
        $customer = new Customer;
        $customer->nama = $request->nama;
        $customer->alamat = $request->alamat;
        $customer->nomorhp = $request->nomorhp;
        $customer->email = $request->email;
        $customer->segmen = $request->segmen;
        $customer->password = bcrypt($request->name);
        $customer->status_akun = $request->status_akun;
        $customer->online = 0;
        $customer->notification_id = '';
        $customer->save();

        return response()->json([
            'status' => 'OK', 
            'message' => 'Data berhasil ditambahkan', 
            'data' => $customer
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if($customer) {
            $customer->nama = $request->nama;
            $customer->alamat = $request->alamat;
            $customer->nomorhp = $request->nomorhp;
            $customer->email = $request->email;
            $customer->segmen = $request->segmen;
            // $customer->password = bcrypt($request->password);
            $customer->status_akun = $request->status_akun;
            $customer->online = 0;
            $customer->notification_id = '';
            $customer->save();
    
            return response()->json([
                'status' => 'OK', 
                'message' => 'Data berhasil diupdate', 
                'data' => $customer
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
        $customer = Customer::find($id);
        if($customer) {
            $customer->delete();

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
