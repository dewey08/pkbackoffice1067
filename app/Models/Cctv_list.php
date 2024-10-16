<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Cctv_list extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'cctv_list';
    protected $primaryKey = 'cctv_list_id';
    protected $fillable = [
        'cctv_list_num',
        'cctv_list_name',        
    ];

  
}
