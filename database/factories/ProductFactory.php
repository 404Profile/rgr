<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name_en = $this->faker->words(3, true);
        $name_ru = $name_en; // Или можно использовать транслитерацию

        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory(),
            'name_ru' => $name_ru,
            'name_en' => $name_en,
            'slug' => Str::slug($name_en),
            'description_ru' => $this->faker->paragraphs(3, true),
            'description_en' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->numberBetween(100, 10000),
            'image' => null,
            'gallery' => null,
            'specifications' => [
                'weight' => $this->faker->numberBetween(100, 5000) . ' г',
                'dimensions' => $this->faker->numberBetween(5, 50) . 'x' .
                    $this->faker->numberBetween(5, 50) . 'x' .
                    $this->faker->numberBetween(5, 50) . ' см',
                'color' => $this->faker->colorName()
            ],
            'quantity' => $this->faker->numberBetween(0, 100),
            'active' => true,
        ];
    }
}
