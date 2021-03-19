<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewKepuasanPelanggan extends Model
{
    use HasFactory;

    protected $table = 'review_kepuasan_pelanggan';
    protected $fillable = [
        'no_service',
        'user_id',
        'jabatan',
        'cabang',
        'rating',
        'ulasan'
    ];

    public function penerimaan()
    {
        return $this->hasOne(PenerimaanBarang::class, 'no_service_penerimaan', 'no_service')->select('no_service_penerimaan', 'id_admin')->with('admin');
    }

    public function pj()
    {
        return $this->hasMany(TeknisiPj::class, 'no_service', 'no_service')->with('teknisi');
    }

    public function arusKas()
    {
        return $this->hasOne(ArusKas::class, 'no_service', 'no_service')->select('no_service', 'id_admin')->with('admin');
    }
}
