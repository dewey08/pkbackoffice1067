<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fire_report extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'fire_report';
    protected $primaryKey = 'fire_report_id';
    protected $fillable = [
        'fire_id',
        'fire_num', 
    ];

  
}
