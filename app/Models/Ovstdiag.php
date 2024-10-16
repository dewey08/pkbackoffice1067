<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Ovstdiag extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'mysql10';
    protected $table = 'ovstdiag';
    protected $primaryKey = 'ovst_diag_id';
    protected $fillable = [  
        'vn',
        'icd10' 
    ];
    public $timestamps = false;     
}
