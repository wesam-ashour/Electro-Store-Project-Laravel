<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $with =['color_product'];
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'boutique_id',
        'admin_id',
        'status',
        'price',
        'offer_price',
        'in_stock_quantity',
        'cover',
    ];
    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Image::class);
    }
    public function category() {
        return $this->belongsToMany(Category::class);
    }
    public function material() {
        return $this->belongsToMany(Material::class);
    }
    public function color_product()
    {
        return $this->hasMany(ProductColor::class);
    }
    public function color() {
        return $this->belongsToMany(Color::class);
    }
    public function size() {
        return $this->belongsToMany(Size::class);
    }


}
