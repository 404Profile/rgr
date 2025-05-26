<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $title_ru = $this->faker->sentence(4);
        $title_en = $this->faker->sentence(4);

        return [
            'title_ru' => $title_ru,
            'title_en' => $title_en,
            'slug' => Str::slug($title_en),
            'content_ru' => $this->faker->paragraphs(5, true),
            'content_en' => $this->faker->paragraphs(5, true),
            'image' => null,
            'type' => 'news',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'active' => true,
        ];
    }

    public function promo(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'promo',
            ];
        });
    }
}
