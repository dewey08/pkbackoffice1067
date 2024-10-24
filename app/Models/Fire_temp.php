<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fire_temp extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'fire_temp';
    protected $primaryKey = 'fire_temp_id';
    protected $fillable = [
        'fire_id',
        'fire_num', 
    ];

  
}
