<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Color extends Model
{
    use HasFactory, SoftDeletes;
    use HasTranslations;

    protected $fillable = ['name', 'color','celebrity_id'];
    public $translatable = ['name'];

    public function material() {
        return $this->belongsToMany(Material::class);
    }



}
