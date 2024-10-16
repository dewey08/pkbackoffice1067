<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_maintenance extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_maintenance';
    protected $primaryKey = 'air_maintenance_id';
    protected $fillable = [
        'air_repaire_id',
        'air_maintenance_name', 
        'air_repaire_type_id'
    ];

  
}
