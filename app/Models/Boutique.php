<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    use HasFactory;
    public const STATUS = ['Active','Inactive'];
    protected $fillable = [
        'name',
        'logo',
        'status',
        'country_id',
    ];
}
