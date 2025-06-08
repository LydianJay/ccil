<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPGroup extends Model
{
    public $table = 'ip_group';
    protected $primaryKey = 'ip_group_id';
    public $timestamps = false;
    protected $fillable = [
        'ip_group_id',
        'ip_name',
    ];
}
