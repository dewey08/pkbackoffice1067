<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Visit_pttype_import_excel extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'visit_pttype_import_excel';
    protected $primaryKey = 'visit_pttype_import_excel_id';
    protected $fillable = [
        // 'visit_pttype_import_excel_id',
        'vn',
        'hcode',
        'hosname',
        'cid',
        'fullname',
        'birthday',
        'homtel',
        'mainpttype',
        'subpttype',
        'repcode',
        'claimcode',
        'claimtype',
        'servicerep',
        'servicename',
        'hncode',
        'ancode',
        'vstdate',
        'regdate',
        'status',
        'repauthen',
        'authentication',
        'staffservice',
        'dateeditauthen',
        'nameeditauthen',
        'comment'
    ];
    public $timestamps = false;     
}
