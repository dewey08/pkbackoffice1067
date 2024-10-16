<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_report_ploblems extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_report_ploblems';
    protected $primaryKey = 'air_report_ploblems_id';
    protected $fillable = [
        'repaire_date_start',
        'repaire_date_end' 
    ];

  
}
