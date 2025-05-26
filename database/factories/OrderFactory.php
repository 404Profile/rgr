<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $statuses = ['pending', 'processing', 'completed', 'canceled'];
        $deliveryMethods = ['pickup', 'delivery'];

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'full_name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'delivery_method' => $this->faker->randomElement($deliveryMethods),
            'delivery_address' => $this->faker->address(),
            'total' => $this->faker->numberBetween(500, 20000),
            'status' => $this->faker->randomElement($statuses),
            'notes' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
        ];
    }
}
