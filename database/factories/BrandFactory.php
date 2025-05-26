<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $name_en = $this->faker->company();
        $name_ru = $name_en;

        return [
            'name_ru' => $name_ru,
            'name_en' => $name_en,
            'slug' => Str::slug($name_en),
            'description_ru' => $this->faker->paragraph(),
            'description_en' => $this->faker->paragraph(),
            'logo' => null,
            'active' => true,
        ];
    }
}
