<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name_ru',
        'name_en',
        'slug',
        'description_ru',
        'description_en',
        'price',
        'image',
        'gallery',
        'specifications',
        'quantity',
        'active',
    ];

    protected $appends = ['name'];

    protected $casts = [
        'gallery' => 'array',
        'specifications' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getNameAttribute()
    {
        $locale = App::getLocale();
        return $this->{"name_$locale"};
    }

    public function getDescriptionAttribute()
    {
        $locale = App::getLocale();
        return $this->{"description_$locale"};
    }
}
