<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Nurse_ksk extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'nurse_ksk';
    protected $primaryKey = 'nurse_ksk_id';
    protected $fillable = [
        'kskdepartment',
        'nursing_product_a',
        'nursing_product_b',
        'nursing_product_c'
         
    ];

  
}
