<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Cctv_check extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'cctv_check';
    protected $primaryKey = 'cctv_check_id';
    protected $fillable = [
        'cctv_check_date',
        'article_num',
        'cctv_camera_screen'         
    ];

  
}
