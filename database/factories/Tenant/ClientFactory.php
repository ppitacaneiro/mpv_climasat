<?php

namespace Database\Factories\Tenant;

use App\Models\Tenant\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'tax_id' => strtoupper($this->faker->bothify('??########')),
            'contact' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->companyEmail,
            'address' => $this->faker->address,
            'history' => $this->faker->paragraph,
        ];
    }
}