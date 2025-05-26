<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ru',
        'title_en',
        'slug',
        'content_ru',
        'content_en',
        'meta_description_ru',
        'meta_description_en',
        'active',
    ];

    public function getTitleAttribute()
    {
        $locale = App::getLocale();
        return $this->{"title_$locale"};
    }

    public function getContentAttribute()
    {
        $locale = App::getLocale();
        return $this->{"content_$locale"};
    }

    public function getMetaDescriptionAttribute()
    {
        $locale = App::getLocale();
        return $this->{"meta_description_$locale"};
    }
}
