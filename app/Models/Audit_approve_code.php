<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Audit_approve_code extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'audit_approve_code';
    protected $primaryKey = 'audit_approve_code_id';
    protected $fillable = [
        'vn',
        'hn', 
    ];

  
}
