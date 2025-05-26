<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'address_ru' => $this->faker->address(),
            'address_en' => $this->faker->address(),
            'map_latitude' => $this->faker->latitude(),
            'map_longitude' => $this->faker->longitude(),
            'social_links' => [
                'facebook' => 'https://facebook.com/',
                'instagram' => 'https://instagram.com/',
                'twitter' => 'https://twitter.com/',
                'youtube' => 'https://youtube.com/'
            ],
            'working_hours_ru' => 'Пн-Пт: 9:00 - 18:00, Сб: 10:00 - 16:00, Вс: выходной',
            'working_hours_en' => 'Mon-Fri: 9:00 - 18:00, Sat: 10:00 - 16:00, Sun: closed',
        ];
    }
}
