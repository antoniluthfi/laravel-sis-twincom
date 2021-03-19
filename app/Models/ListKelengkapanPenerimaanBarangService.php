<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListKelengkapanPenerimaanBarangService extends Model
{
    use HasFactory;

    protected $table = 'list_kelengkapan_penerimaan_barang_service';
    protected $primaryKey = 'no_service';
    protected $fillable = [
        'no_service',
        'kelengkapan',
    ];
}
