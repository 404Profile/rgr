<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name_ru',
        'name_en',
        'slug',
        'description_ru',
        'description_en',
        'image',
        'active',
    ];

    protected $appends = ['name', 'description'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (!$category->slug) {
                $category->slug = static::createUniqueSlug($category->name_ru ?: $category->name_en);
            } else {
                $category->slug = static::createUniqueSlug($category->slug);
            }
        });
    }

    public static function createUniqueSlug($value)
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $count = 1;

        while (static::whereSlug($slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
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
