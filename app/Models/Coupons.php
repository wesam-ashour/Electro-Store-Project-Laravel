<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupons extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'coupons';
    public const COUPONS = ['1', '0'];

    protected $fillable = [
        'title', 'code', 'value', 'type', 'min_order_amt', 'is_one_time', 'status'
    ];
}
