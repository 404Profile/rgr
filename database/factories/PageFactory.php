<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        $title_ru = $this->faker->sentence(3);
        $title_en = $this->faker->sentence(3);

        return [
            'title_ru' => $title_ru,
            'title_en' => $title_en,
            'slug' => Str::slug($title_en),
            'content_ru' => $this->faker->paragraphs(5, true),
            'content_en' => $this->faker->paragraphs(5, true),
            'meta_description_ru' => $this->faker->sentence(),
            'meta_description_en' => $this->faker->sentence(),
            'active' => true,
        ];
    }
}
