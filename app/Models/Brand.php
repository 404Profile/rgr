<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ru',
        'name_en',
        'slug',
        'description_ru',
        'description_en',
        'logo',
        'active',
    ];

    protected $appends = ['name', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class);
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
