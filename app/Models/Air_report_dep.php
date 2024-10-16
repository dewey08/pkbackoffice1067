<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_report_dep extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_report_dep';
    protected $primaryKey = 'air_report_dep_id';
    protected $fillable = [
        'years',
        'air_plan_year', 
    ];

}
