<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;
    public const STATUS = ['1','0'];
    protected $fillable = [
        'name',
        'status',
        'image',
        'order',
    ];
}
