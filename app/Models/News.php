<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'type',
        'published_at',
        'active',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('active', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');
    }

    public function scopeNews($query)
    {
        return $query->where('type', 'news');
    }

    public function scopePromo($query)
    {
        return $query->where('type', 'promo');
    }
}
