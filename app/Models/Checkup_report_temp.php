<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Checkup_report_temp extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'checkup_report_temp';
    protected $primaryKey = 'checkup_report_temp_id';
    protected $fillable = [
        'vn',
        'hn',
        'vstdate'         
    ];

  
}
