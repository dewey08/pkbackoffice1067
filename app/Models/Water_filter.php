<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Water_filter extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'water_filter';
    protected $primaryKey = 'water_filter_id';
    protected $fillable = [
        'water_year',
        'water_code', 
    ];

}
