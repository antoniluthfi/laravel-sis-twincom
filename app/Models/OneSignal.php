<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneSignal extends Model
{
    use HasFactory;

    protected $table = 'onesignal';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'player_id'
    ];
}
