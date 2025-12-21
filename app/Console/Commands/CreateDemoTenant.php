<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TenantService;
use App\Models\User;

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

        $userDemo = User::create([
            'name' => 'Demo User',
            'email' => 'demo@demo.com',
            'password' => bcrypt('demo'),
        ]);

        $tenant = $tenantService->createTenant([
            'company_name' => 'Demo Company',
            'user_id' => $userDemo->id,
        ]);
    }
}
