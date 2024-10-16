<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Water_check extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'water_check';
    protected $primaryKey = 'water_check_id';
    protected $fillable = [
        'check_year',
        'check_date',
        'check_time'         
    ];

  
}
