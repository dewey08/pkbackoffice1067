<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_apiofc_dru extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'd_apiofc_dru';
    protected $primaryKey = 'd_apiofc_dru_id';
    protected $fillable = [
        'blobName',
        'blobType',
        'blob'         
    ];

  
}
