<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_trash_set extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'env_trash_set';
    protected $primaryKey = 'trash_set_id';
    // public $timestamps = false;  
    protected $fillable = [
        'trash_set_name',
        'trash_set_unit'
              
    ];

  
}