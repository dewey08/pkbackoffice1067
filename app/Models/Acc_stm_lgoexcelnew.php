<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_stm_lgoexcelnew extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_stm_lgoexcelnew';
    protected $primaryKey = 'acc_stm_lgoexcelnew_id';
    protected $fillable = [
        'transfer_date', 
    ];

  
}
