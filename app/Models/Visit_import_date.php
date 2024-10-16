<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Visit_import_date extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'visit_import_date';
    protected $primaryKey = 'visit_import_date_id';
    protected $fillable = [
        'startdate',
        'enddate'        
    ];

  
}