<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelengkapan extends Model
{
    use HasFactory;

    protected $table = 'kelengkapan';
    protected $fillable = [
        'nama_kelengkapan'
    ];
}
