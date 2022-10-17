<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'path',
        'admin_id',
        'user_id',
        'product_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
    public function product(){
        return $this->hasMany(Image::class);
    }
}
