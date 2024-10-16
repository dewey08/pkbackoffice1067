<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_edit_log extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_edit_log';
    protected $primaryKey = 'air_edit_log_id';
    protected $fillable = [
        'user_id',
        'user_name', 
    ];

  
}
