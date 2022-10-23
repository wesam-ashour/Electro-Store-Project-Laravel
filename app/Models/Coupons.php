<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    protected $fillable = [
        'title', 'code', 'value', 'type', 'min_order_amt', 'is_one_time', 'status',
    ];
}
