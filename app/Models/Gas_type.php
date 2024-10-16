<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Gas_type extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'gas_type';
    protected $primaryKey = 'gas_type_id';
    protected $fillable = [
        'gas_type_name',
        'active', 
    ];

}
