<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseholdHead extends Model
{
    public $table = 'household_head';
    protected $primaryKey = 'household_head_id';
    public $timestamps = false;
    protected $fillable = [
        'household_head_id',
        'household_id',
        'individual_id',
    ];
}
