<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArusKas extends Model
{
    use HasFactory;

    protected $table = 'arus_kas';
    protected $primaryKey = 'no_bukti';
    protected $fillable = [
        'no_pengembalian',
        'no_pembayaran',
        'no_service',
        'norekening',
        'cek_stiker',
        'kas',
        'masuk',
        'keluar',
        'dp',
        'nominal',
        'id_pj',
        'id_admin',
        'keterangan',
        'id_sandi',
        'cabang'
    ];

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'id_admin')->select('id', 'name');
    }

    public function penerimaan()
    {
        return $this->hasOne(PenerimaanBarang::class, 'no_service_penerimaan', 'no_service')->with('cabang');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'no_pembayaran', 'no_pembayaran')->select('no_pembayaran');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'no_pengembalian', 'no_pengembalian')->select('no_pengembalian');
    }

    public function transaksi()
    {
        return $this->hasOne(SandiTransaksi::class, 'id', 'id_sandi');
    }

    public function pengerjaan()
    {
        return $this->hasOne(Pengerjaan::class, 'no_service', 'no_service')->select('no_service', 'cek_stiker', 'status_pengerjaan', 'biaya_service');
    }

    public function detailPengerjaan()
    {
        return $this->hasOne(DetailPengerjaan::class, 'no_service', 'no_service');
    }

    public function pj()
    {
        return $this->hasOne(TeknisiPj::class, 'no_service', 'no_service')->select('no_service', 'id_teknisi')->with('teknisi');
    }
}
