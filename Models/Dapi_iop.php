<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dapi_iop extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dapi_iop';
    protected $primaryKey = 'dapi_iop_id';
    protected $fillable = [
        'blobName',
        'blobType',
        'blob'         
    ];

  
}