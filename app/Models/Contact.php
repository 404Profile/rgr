<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'email',
        'address_ru',
        'address_en',
        'map_latitude',
        'map_longitude',
        'social_links',
        'working_hours_ru',
        'working_hours_en',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    public function getAddressAttribute()
    {
        $locale = App::getLocale();
        return $this->{"address_$locale"};
    }

    public function getWorkingHoursAttribute()
    {
        $locale = App::getLocale();
        return $this->{"working_hours_$locale"};
    }
}
