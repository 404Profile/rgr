<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'name_en',
        'slug',
        'description',
        'description_en',
        'price',
        'image',
        'gallery',
        'specifications',
        'quantity',
        'active',
    ];

    protected $casts = [
        'gallery' => 'array',
        'specifications' => 'array',
    ];

    protected static function booted()
    {
        static::saving(function ($product) {
            if (empty($product->name_en) && !empty($product->name)) {
                $product->name_en = self::translateToEnglish($product->name);
            }

            if (empty($product->description_en) && !empty($product->description)) {
                $product->description_en = self::translateToEnglish($product->description);
            }
        });
    }

    protected static function translateToEnglish(string $text): ?string
    {
        try {
            $response = Http::get('https://ftapi.pythonanywhere.com/translate', [
                'sl' => 'ru',
                'dl' => 'en',
                'text' => $text,
            ]);

            if ($response->successful()) {
                return $response->json('destination-text');
            }

            Log::error('Translation API error', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        } catch (\Exception $e) {
            Log::error('Translation failed', ['error' => $e->getMessage()]);
        }

        return null;
    }

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
}
