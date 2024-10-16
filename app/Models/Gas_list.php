<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Gas_list extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'gas_list';
    protected $primaryKey = 'gas_list_id';
    protected $fillable = [
        'gas_type',
        'gas_list_num', 
    ];

}
