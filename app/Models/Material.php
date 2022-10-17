<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function color() {
        return $this->belongsToMany(Color::class);
    }
    public function product() {
        return $this->belongsToMany(Product::class);
    }

}
