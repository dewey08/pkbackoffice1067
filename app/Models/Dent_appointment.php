<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dent_appointment extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dent_appointment';
    protected $primaryKey = 'dent_appointment_id';
    // public $timestamps = false;  
    protected $fillable = [
        'dent_hn',
        'dent_tel',
        'dent_work',
        'dent_date',
        'dent_time',       
        'appointment_id',
        'appointment_name',
        'dent_doctor'
          
        
        
    ];

  
}
