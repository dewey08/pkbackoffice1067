<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dapianc_ldv extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dapianc_ldv';
    protected $primaryKey = 'dapianc_ldv_id';
    protected $fillable = [
        'blobName',
        'blobType',
        'blob'         
    ];

  
}
