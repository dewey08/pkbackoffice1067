<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_plan_excel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_plan_excel';
    protected $primaryKey = 'air_plan_excel_id';
    protected $fillable = [
        'air_plan_year',
        'air_list_num', 
    ];

  
}
