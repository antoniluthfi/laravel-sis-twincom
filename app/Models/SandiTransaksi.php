<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SandiTransaksi extends Model
{
    use HasFactory;

    protected $table = 'sandi_transaksi';
    protected $fillable = [
        'sandi_transaksi',
        'jenis_transaksi'
    ];
}
