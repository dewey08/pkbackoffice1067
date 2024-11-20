<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_lgo_repexcel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_lgo_repexcel';
    protected $primaryKey = 'acc_lgo_repexcel_id';
    protected $fillable = [
        'rep',
        'no',
        'tran_id'         
    ];

  
}
