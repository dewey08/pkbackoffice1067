<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Opitemrece217 extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'opitemrece';
    protected $primaryKey = 'hos_guid';
    public $timestamps = false;     
}
