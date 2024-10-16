<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Gas_dot_control extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'gas_dot_control';
    protected $primaryKey = 'gas_dot_control_id';
    protected $fillable = [
        'gas_list_id',
        'dot', 
    ];

}
