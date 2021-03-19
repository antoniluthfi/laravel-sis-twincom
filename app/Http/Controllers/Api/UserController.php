<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'OK', 
            'data' => User::with('cabang')->get()
        ], 200);
    }

    public function getCurrentUser()
    {
        $user = Auth::user();
        $user['cabang'] = Auth::user()->cabang;
        return response()->json([
            'status' => 'OK', 
            'data' => $user
        ], 200);
    }

    public function getCurrentEncryptedUser($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::find($id);
        if(!$user) {
            $user = Customer::find($id);
        }
        
        return response()->json([
            'status' => 'OK', 
            'data' => $user
        ], 200);
    }

    public function getUserById($id)
    {
        $user = User::with('cabang')->find($id);
        return response()->json([
            'status' => 'OK',
            'data' => $user
        ], 200);
    }

    public function getUserByName($name)
    {
        $user = User::with('cabang')->where('name', $name)->first();
        return response()->json([
            'status' => 'OK',
            'data' => $user
        ], 200);
    }

    public function getUserByRole($role)
    {
        $user = User::with('cabang')->where('jabatan', $role)->get();
        return response()->json([
            'status' => 'OK',
            'data' => $user
        ], 200);
    }

    public function getUserByRoleAndCabang($role, $cabang)
    {
        $user = User::with('cabang')->where(['jabatan' => $role, 'cab_penempatan' => $cabang])->get();
        return response()->json([
            'status' => 'OK',
            'data' => $user
        ], 200);
    }

    public function getRatingAdmin()
    {
        $user = DB::select("SELECT users.id, users.name, users.jabatan, users.cab_penempatan, users.created_at, SUM(rating) AS sum_rate, COUNT(rating) AS total_rate, (SUM(rating) / COUNT(rating)) AS average, cabang FROM `users` LEFT JOIN review_kepuasan_pelanggan ON users.id = review_kepuasan_pelanggan.user_id GROUP BY review_kepuasan_pelanggan.user_id HAVING users.jabatan = 'admin service'");
        
        return response()->json([
            'status' => 'OK',
            'data' => $user
        ], 200);
    }

    public function getRatingTeknisi()
    {
        $user = DB::select("SELECT users.id, users.name, users.jabatan, users.cab_penempatan, users.created_at, SUM(rating) AS sum_rate, COUNT(rating) AS total_rate, (SUM(rating) / COUNT(rating)) AS average, cabang FROM `users` LEFT JOIN review_kepuasan_pelanggan ON users.id = review_kepuasan_pelanggan.user_id GROUP BY review_kepuasan_pelanggan.user_id HAVING users.jabatan = 'teknisi'");

        return response()->json([
            'status' => 'OK',
            'data' => $user
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data sudah ada'
            ], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $user = User::create($input);

        return response()->json([
            'status' => 'OK', 
            'message' => 'Data berhasil ditambahkan', 
            'data' => $user
        ], 200);
    }

    public function resetPassword(Request $request, $id)
    {
        $input = [];
        $id = Crypt::decrypt($id);
        $user = User::find($id);
        if(!$user) {
            $user = Customer::find($id);
        }
        
        $input['password'] = bcrypt($request->password);
        $user->fill($input)->save();

        return response()->json([
            'status' => 'OK', 
            'message' => 'Password berhasil direset. Silahkan login kembali', 
            'data' => $user
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $input = $request->all();
        $user = $user->fill($input)->save();

        return response()->json([
            'status' => 'OK', 
            'message' => 'Data berhasil diupdate',
            'data' => $user
        ], 200);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus'
        ], 200);
    }
}
