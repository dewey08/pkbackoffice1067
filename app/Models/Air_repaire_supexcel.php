<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_repaire_supexcel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_repaire_supexcel';
    protected $primaryKey = 'air_repaire_supexcel_id';
    protected $fillable = [
        'repaire_date',
        'repaire_time' 
    ];

  
}
