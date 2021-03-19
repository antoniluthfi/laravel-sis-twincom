<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanPengiriman extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_pengiriman';
    protected $fillable = [
        'no_surat_jalan',
        'no_service',
        'id_partner',
        'id_penerima',
        'status_penerimaan'
    ];

    public function suratJalan()
    {
        return $this->hasOne(PengirimanBarang::class, 'no_surat_jalan', 'no_surat_jalan')->select('no_surat_jalan');
    }

    public function penerimaan()
    {
        return $this->hasOne(PenerimaanBarang::class, 'no_service_penerimaan', 'no_service');
    }

    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'id_partner');
    }

    public function penerima()
    {
        return $this->hasOne(User::class, 'id', 'id_penerima')->select('id', 'name');
    }
}
