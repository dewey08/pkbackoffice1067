<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Wh_stock_export_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'wh_stock_export_sub';
    protected $primaryKey = 'wh_stock_export_sub_id';
    protected $fillable = [
        'wh_stock_export_id',
        'wh_request_id', 
    ];

  
}
