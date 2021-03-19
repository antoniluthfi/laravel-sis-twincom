<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_barang';
    protected $primaryKey = 'no_service_penerimaan';
    protected $fillable = [
        'jenis_penerimaan',
        'id_customer',
        'id_cabang',
        'id_bj',
        'id_admin',
        'id_teknisi',
        'merek',
        'tipe',
        'sn',
        'kelengkapan',
        'problem',
        'kondisi',
        'data_penting',
        'permintaan',
        'keterangan',
        'estimasi',
        'status_garansi',
        'sisa_garansi',
        'layanan',
        'link_video',
        'shift',
        'rma',
        'tempo'
    ];

    public function cabang()
    {
        return $this->hasOne(Cabang::class, 'id', 'id_cabang')->select('id', 'nama_cabang');
    }

    public function bj()
    {
        return $this->hasOne(BarangJasa::class, 'id', 'id_bj')->select('id', 'nama_bj', 'jenis');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'id_customer')->select('id', 'nama', 'nomorhp', 'email');
    }

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'id_admin')->select('id', 'name');
    }

    public function teknisi()
    {
        return $this->hasMany(TeknisiPj::class, 'no_service', 'no_service_penerimaan')->with('teknisi');
    }

    public function list_kelengkapan()
    {
        return $this->hasMany(ListKelengkapanPenerimaanBarangService::class, 'no_service', 'no_service_penerimaan');
    }

    public function pengajuan()
    {
        return $this->hasOne(PengajuanPembelianBarangSecond::class, 'no_service', 'no_service_penerimaan')->select('no_service', 'pengajuan_harga');
    }

    public function pengerjaan()
    {
        return $this->hasOne(Pengerjaan::class, 'no_service', 'no_service_penerimaan')->with('partner')->select('no_pengerjaan', 'no_service', 'status_pengerjaan', 'id_partner');
    }

    public function arusKas()
    {
        return $this->hasOne(ArusKas::class, 'no_service', 'no_service')->select('no_service');
    }

    public function ratingAdmin()
    {
        return $this->hasOne(ReviewKepuasanPelanggan::class, 'no_service', 'no_service_penerimaan');
    }
}
