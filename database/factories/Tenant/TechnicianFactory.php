<?php

namespace Database\Factories\Tenant;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant\Technician;
use App\Models\User;

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
        $email = $this->faker->unique()->safeEmail();
        $name = $this->faker->name();
        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt('password'), // Default password
            'role' => 'technician',
        ]);
        $user->save();

        return [
            'name' => $name,
            'user_id' => $user->id,
            'tax_id' => $this->faker->unique()->bothify('??########'),
            'specialty' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $email,
            'availability' => $this->faker->randomElement($availabilities),
        ];
    }
}
