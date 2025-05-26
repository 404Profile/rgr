<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name_en = $this->faker->word();
        $name_ru = $name_en; // Или можно использовать транслитерацию

        return [
            'parent_id' => null,
            'name_ru' => $name_ru,
            'name_en' => $name_en,
            'slug' => Str::slug($name_en),
            'description_ru' => $this->faker->paragraph(),
            'description_en' => $this->faker->paragraph(),
            'image' => null,
            'active' => true,
        ];
    }

    public function child(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => Category::inRandomOrder()->first()->id ?? null,
            ];
        });
    }
}
