<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    public $table = 'individual';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'household_id',
        'family_id',
        'ip_group_id',
        'family_role',
        'fname',
        'lname',
        'mname',
        'ext',
        'dob',
        'contactno',
        'address',
        'gender',
        'is_half_blooded',
    ];
}
