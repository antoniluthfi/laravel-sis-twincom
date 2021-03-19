<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'no_pembayaran';
    protected $fillable = [
        'no_service',
        'norekening',
        'kas',
        'nominal',
        'dp',
        'keterangan_pembayaran',
        'shift',
        'id_admin',
        'status_pembayaran'
    ];

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'id_admin')->select('id', 'name');
    }

    public function penerimaan()
    {
        return $this->hasOne(PenerimaanBarang::class, 'no_service_penerimaan', 'no_service')->with('bj', 'cabang', 'customer');
    }

    public function arusKas()
    {
        return $this->hasOne(ArusKas::class, 'no_service', 'no_service')->select('no_service', 'no_bukti', 'id_sandi')->with('transaksi');
    }

    public function pengerjaan()
    {
        return $this->hasOne(Pengerjaan::class, 'no_service', 'no_service')->select('no_service', 'biaya_service');
    }
}
