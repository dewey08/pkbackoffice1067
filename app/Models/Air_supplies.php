<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_supplies extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_supplies';
    protected $primaryKey = 'air_supplies_id';
    protected $fillable = [
        'supplies_name',
        'supplies_tel', 
    ];

  
}
