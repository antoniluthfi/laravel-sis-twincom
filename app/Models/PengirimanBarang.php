<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanBarang extends Model
{
    use HasFactory;

    protected $table = 'pengiriman_barang';
    protected $primaryKey = 'no_surat_jalan';
    protected $fillable = [
        'id_admin',
        'id_pengirim',
        'id_pengantar',
        'id_partner',
        'keterangan'
    ];

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'id_admin')->select('id', 'name', 'cab_penempatan')->with('cabang');
    }

    public function pengirim()
    {
        return $this->hasOne(User::class, 'id', 'id_pengirim')->select('id', 'name', 'cab_penempatan');
    }

    public function pengantar()
    {
        return $this->hasOne(User::class, 'id', 'id_pengantar')->select('id', 'name', 'cab_penempatan');
    }

    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'id_partner')->select('id', 'nama', 'alamat');
    }

    public function list_pengiriman()
    {
        return $this->hasMany(ListPengiriman::class, 'no_surat_jalan', 'no_surat_jalan')->with('penerimaan');
    }
}
