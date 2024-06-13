<?php

namespace Database\Factories;

use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VaccineDose>
 */
class VaccineDoseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vaccine_id' => Vaccine::pluck('id')->random(),
            'serial_number' => $this->faker->unique()->slug,
            'volume' => $this->faker->randomElement([5, 10]),
            'expiration_date' => $this->faker->dateTimeBetween('now', '+2 years'),
        ];
    }
}
