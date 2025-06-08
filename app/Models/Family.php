<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public $table = 'family';
    protected $primaryKey = 'family_id';
    public $timestamps = false;
    protected $fillable = [
        'family_id',
        'no_members',
        'household_id',
    ];
}
