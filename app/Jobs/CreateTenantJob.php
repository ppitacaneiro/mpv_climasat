<?php

namespace App\Jobs;

use App\Services\TenantService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;

class CreateTenantJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $companyName,
        public int $userId,
        public ?int $subscriptionPlanId = null
    ) {}

    /**
     * Execute the job.
     */
    public function handle(TenantService $tenantService): void
    {
        $tenantService->createTenant([
            'company_name' => $this->companyName,
            'user_id' => $this->userId,
            'subscription_plan_id' => $this->subscriptionPlanId,
        ]);
    }
}
