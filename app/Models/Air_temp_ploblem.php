<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_temp_ploblem extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_temp_ploblem';
    protected $primaryKey = 'air_temp_ploblem_id';
    protected $fillable = [
        'air_list_num', 
    ];

  
}
