<?php

namespace Database\Factories;

use App\Enums\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(Notification::cases())->value,
            'receiver' => fake()->safeEmail(),
            'value' => fake()->uuid(),
        ];
    }
}
