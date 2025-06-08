<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    
    public $table = 'household';
    protected $primaryKey = 'household_id';
    public $timestamps = false;
    protected $fillable = [
        'household_id',
        'family_id',
        'no_members',
        'address',
    ];
}
