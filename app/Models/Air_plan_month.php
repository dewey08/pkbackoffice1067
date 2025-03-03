<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_plan_month extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_plan_month';
    protected $primaryKey = 'air_plan_month_id';
    protected $fillable = [
        'years',
        'air_plan_month', 
    ];

  
}
