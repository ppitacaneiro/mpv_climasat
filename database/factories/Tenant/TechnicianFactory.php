<?php

namespace Database\Factories\Tenant;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant\Technician;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant\Technician>
 */
class TechnicianFactory extends Factory
{
    protected $model = Technician::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $availabilities = ['available', 'busy', 'off'];

        return [
            'name' => $this->faker->name(),
            'tax_id' => $this->faker->unique()->bothify('??########'),
            'specialty' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'availability' => $this->faker->randomElement($availabilities),
        ];
    }
}
