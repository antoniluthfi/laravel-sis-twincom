<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanPartner extends Model
{
    use HasFactory;

    protected $table = 'tagihan_partner';
    protected $primaryKey = 'no_service';
    protected $fillable = [
        'no_service',
        'id_partner',
        'biaya_service',
        'nominal',
        'keterangan',
        'status_pembayaran'
    ];

    public function penerimaan()
    {
        return $this->hasOne(PenerimaanBarang::class, 'no_service_penerimaan', 'no_service');
    }

    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'id_partner');
    }
}
