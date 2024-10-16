<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Authen_date extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'authen_date';
    protected $primaryKey = 'authen_id';
    protected $fillable = [
        'authen_date',
        'authen_time', 
    ];

  
}
