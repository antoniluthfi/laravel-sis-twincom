<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengerjaan extends Model
{
    use HasFactory;

    protected $table = 'detail_pengerjaan';
    protected $primaryKey = 'no_pengerjaan';
    protected $fillable = [
        'no_pengerjaan',
        'no_service',
        'waktu_mulai',
        'waktu_selesai',
        'pengerjaan',
        'keterangan'
    ];
}
