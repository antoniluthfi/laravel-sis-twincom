<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPembelianBarangSecond extends Model
{
    use HasFactory;

    protected $table = 'pembelian_barang_second';
    protected $primaryKey = 'no_service';
    protected $fillable = [
        'no_service',
        'nama_toko_asal',
        'harga_beli',
        'lama_pemakaian',
        'pengajuan_harga',
        'tanggal_pembelian',
        'segel_distri',
        'alasan_menjual',
        'id_teknisi',
        'keterangan',
        'processor',
        'memory',
        'harddisk',
        'graphic_card',
        'cd_dvd',
        'keyboard',
        'lcd',
        'usb',
        'camera',
        'charger',
        'casing',
        'touchpad',
        'wifi',
        'lan',
        'sound',
        'baterai',
        'nota',
        'kotak',
        'tas',
        'dibeli',
        'kode_jual',
        'nominal'
    ];

    public function penerimaan()
    {
        return $this->hasOne(PenerimaanBarang::class, 'no_service_penerimaan', 'no_service')->select('no_service_penerimaan', 'id_cabang', 'id_customer', 'merek', 'tipe', 'sn')->with('customer', 'cabang');
    }

    public function pengecek()
    {
        return $this->hasOne(User::class, 'id', 'id_teknisi')->select('id', 'name', 'nomorhp');
    }

    public function pengerjaan()
    {
        return $this->hasOne(Pengerjaan::class, 'no_service', 'no_service')->select('no_service', 'no_pengerjaan');
    }
}
