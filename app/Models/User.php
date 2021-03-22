<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alamat',
        'nomorhp',
        'email',
        'password',
        'cab_penempatan',
        'status_akun',
        'online',
        'shift',
        'jabatan'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        // 'cab_penempatan'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cabang()
    {
        return $this->hasOne(Cabang::class, 'nama_cabang', 'cab_penempatan')->select('id', 'nama_cabang', 'alamat');
    }

    public function diskon()
    {
        return $this->hasOne(Diskon::class, 'user_id', 'id');
    }

    public function OauthAcessToken() 
    {
        return $this->hasMany(OauthAccessToken::class);
    }

    public function penerimaan()
    {
        return $this->hasMany(PenerimaanBarang::class, 'id_admin', 'id')->select('id_admin', 'no_service_penerimaan')->with('ratingAdmin');
    }

    public function pengerjaan()
    {
        return $this->hasMany(TeknisiPj::class, 'id_teknisi', 'id')->select('id_teknisi', 'no_service')->with('ratingTeknisi');
    }

    public function ratingPelayanan()
    {
        return $this->hasMany(ReviewKepuasanPelanggan::class, 'user_id', 'id');
    }
}