<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['parent_id', 'name','haveSub','celebrity_id','seeder'];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function product()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }


}
