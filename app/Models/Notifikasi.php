<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $fillable = [
        'user_id',
        'hak_akses',
        'keterangan'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function job()
    {
        return $this->hasMany(TeknisiPj::class, 'id_teknisi', 'user_id')->with('pengerjaan');
    }
}
