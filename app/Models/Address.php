<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'area',
        'block_no',
        'street_no',
        'building_type',
        'house_no',
        'building_no',
        'floor_no',
        'flat_no',
        'landmark',
    ];

}
