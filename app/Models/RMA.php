<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RMA extends Model
{
    use HasFactory;

    protected $table = 'rma';
    protected $fillable = [
        'nama'
    ];
}
