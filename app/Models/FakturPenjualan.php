<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturPenjualan extends Model
{
    use HasFactory;

    protected $table = 'faktur_penjualan';
    protected $primaryKey = 'no_faktur';
    protected $fillable = [
        'no_faktur',
        'no_service',
        'tgl_faktur',
        'tgl_segel_toko',
        'ketentuan'
    ];

    public function penerimaan() {
        return $this->hasOne(PenerimaanBarang::class, 'no_faktur', 'no_faktur');
    }
}
