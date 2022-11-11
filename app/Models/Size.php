<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Size extends Model
{
    use HasFactory, SoftDeletes;
    use HasTranslations;

    protected $fillable = ['name','celebrity_id'];
    public $translatable = ['name'];
    public function product() {
        return $this->belongsToMany(Product::class);
    }
}
