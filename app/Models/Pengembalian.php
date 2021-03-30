<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';
    protected $primaryKey = 'no_pengembalian';
    protected $fillable = [
        'no_service',
        'id_admin',
        'status_pengerjaan',
        'status_pengembalian',
        'cek_stiker',
        'status_pembayaran',
        'shift',
        'cabang',
        'nominal',
        'diskon',
        'diskon_kecewa',
    ];

    public function penerimaan()
    {
        return $this->hasOne(PenerimaanBarang::class, 'no_service_penerimaan', 'no_service')->with('cabang', 'customer', 'bj', 'admin', 'teknisi');
    }

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'id_admin')->select('id', 'name');
    }

    public function pj()
    {
        return $this->hasOne(TeknisiPj::class, 'no_service', 'no_service')->select('no_service', 'id_teknisi')->with('teknisi');
    }

    public function pengerjaan()
    {
        return $this->hasOne(Pengerjaan::class, 'no_service', 'no_service')->select('no_service', 'cek_stiker', 'status_pengerjaan', 'biaya_service');
    }

    public function detailPengerjaan()
    {
        return $this->hasOne(DetailPengerjaan::class, 'no_service', 'no_service');
    }
}
