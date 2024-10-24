<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dent_appointment_type extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dent_appointment_type';
    protected $primaryKey = 'appointment_id';
    // public $timestamps = false;  
    protected $fillable = [
        'appointment_name',        
        'status'   
        
        
    ];

  
}
