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
        'address',
        'map_latitude',
        'map_longitude',
        'social_links',
        'working_hours',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}
