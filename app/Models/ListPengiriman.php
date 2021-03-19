<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPengiriman extends Model
{
    use HasFactory;
    
    protected $table = 'list_pengiriman';
    protected $primaryKey = 'no_surat_jalan';
    protected $fillable = [
        'no_surat_jalan',
        'no_service',
        'kelengkapan',
        'kerusakan',
        'status_pengiriman'
    ];

    public function suratJalan()
    {
        return $this->hasOne(PengirimanBarang::class, 'no_surat_jalan', 'no_surat_jalan')->select('no_surat_jalan', 'id_admin', 'id_pengirim', 'id_pengantar', 'id_partner')->with('admin', 'pengirim', 'pengantar', 'partner');
    }

    public function penerimaan()
    {
        return $this->hasOne(PenerimaanBarang::class, 'no_service_penerimaan', 'no_service')->select('no_service_penerimaan', 'id_cabang', 'id_bj', 'merek', 'tipe', 'sn')->with('cabang', 'bj');
    }

    public function tagihanPartner()
    {
        return $this->hasOne(TagihanPartner::class, 'no_service', 'no_service');
    }
}
