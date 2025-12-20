<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the tenant database seeds.
     */
    public function run(): void
    {
        $this->call([
            FaultTypeSeeder::class,

            // Mock Data Seeders
            ClientSeeder::class,
            TechnicianSeeder::class,
        ]);
    }
}
