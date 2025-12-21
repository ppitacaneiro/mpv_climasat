<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TenantService;
use App\Models\User;
use Illuminate\Container\Attributes\Log;

class CreateDemoTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-demo-tenant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a demo tenant for testing purposes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantService = app(TenantService::class);

        try {
            $userDemo = User::create([
                'name' => 'Demo User',
                'email' => 'demo@demo.com',
                'password' => bcrypt('demo'),
            ]);

            $tenant = $tenantService->createTenant([
                'company_name' => 'Demo Company',
                'user_id' => $userDemo->id,
                'twilio_number' => '+14155238886',
            ]);
            $this->info("Demo tenant created with ID: {$tenant->id}");
        } catch (\Exception $e) {
            $this->error("Error creating demo tenant: " . $e->getMessage());
        }
    }
}
