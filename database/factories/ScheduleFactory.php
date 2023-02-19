<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'title' => fake()->realText('30'),
            'description' => fake()->realText('200'),
            'deadline' => fake()->dateTimeBetween($startDate = 'now', $endDate = '+2 week'),
            'status' => rand(1, 3),
        ];
    }
}
