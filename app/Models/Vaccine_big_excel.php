<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Vaccine_big_excel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'vaccine_big_excel';
    protected $primaryKey = 'vaccine_big_excel_id';
    protected $fillable = [
        'ptname',
        'cid',        
    ];

  
}
