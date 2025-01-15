<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'start_date' => $this->faker->dateTimeBetween('-3 months', now()),
            'end_date' => $this->faker->dateTimeBetween(now(), '+3 months'),
            'max_participant_count' => $this->faker->numberBetween(1,40),
            'created_by' => User::factory()
        ];
    }
}
