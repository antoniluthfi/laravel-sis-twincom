<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeknisiPj extends Model
{
    use HasFactory;

    protected $table = 'teknisi_pj';
    protected $primaryKey = 'no_pengerjaan';
    protected $fillable = [
        'no_service',
        'id_teknisi',
        'presentase'
    ];

    public function teknisi() 
    {
        return $this->hasOne(User::class, 'id', 'id_teknisi')->select('id', 'name');
    }

    public function pengerjaan()
    {
        return $this->hasOne(Pengerjaan::class, 'no_service', 'no_service')->with('partner');
    }

    public function penerimaan()
    {
        return $this->hasOne(PenerimaanBarang::class, 'no_service_penerimaan', 'no_service')->select('no_service_penerimaan', 'jenis_penerimaan', 'id_customer', 'id_cabang', 'id_bj', 'merek', 'tipe', 'sn', 'problem', 'kondisi', 'permintaan', 'keterangan', 'kelengkapan', 'tempo')->with('bj', 'customer', 'cabang');
    }

    public function ratingTeknisi()
    {
        return $this->hasOne(ReviewKepuasanPelanggan::class, 'no_service', 'no_service');
    }
}
