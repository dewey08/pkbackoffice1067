<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fire_count_nocheck extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'fire_count_nocheck';
    protected $primaryKey = 'fire_count_nocheck_id';
    protected $fillable = [
        'fire_id',
        'fire_num', 
    ];

  
}
