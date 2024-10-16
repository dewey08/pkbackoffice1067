<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_ofc_dateconfig extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_ofc_dateconfig';
    protected $primaryKey = 'acc_ofc_dateconfig_id';
    protected $fillable = [
        'startdate',
        'enddate', 
    ];

}
