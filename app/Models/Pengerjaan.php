<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengerjaan extends Model
{
    use HasFactory;

    protected $table = 'pengerjaan';
    protected $primaryKey = 'no_pengerjaan';
    protected $fillable = [
        'no_service',
        'id_partner',
        'biaya_service',
        'status_pengerjaan',
        'alasan_batal',
        'harga_beli',
        'alasan_tidak_beli',
        'garansi',
        'cek_stiker'
    ];

    public function penerimaan()
    {
        return $this->hasOne(PenerimaanBarang::class, 'no_service_penerimaan', 'no_service')->with('bj', 'customer', 'cabang', 'list_kelengkapan');
    }

    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'id_partner')->select('id', 'nama');
    }

    public function detailPengerjaan()
    {
        return $this->hasOne(DetailPengerjaan::class, 'no_pengerjaan', 'no_pengerjaan');
    }

    public function teknisi()
    {
        return $this->hasMany(TeknisiPj::class, 'no_service', 'no_service')->select('no_service', 'id_teknisi')->with('teknisi');
    }
}
