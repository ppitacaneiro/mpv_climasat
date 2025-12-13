<?php

namespace App\Services;

use App\Models\SubscriptionPlan;
use App\Models\Tenant;
use Illuminate\Support\Str;

class TenantService
{
    /**
     * Get paginated tenants with their users.
     */
    public function getPaginatedTenants(int $perPage = 10)
    {
        return Tenant::with('user')->latest()->paginate($perPage);
    }

    /**
     * Get a tenant with its relationships.
     */
    public function getTenantWithRelations(Tenant $tenant)
    {
        return $tenant->load('user', 'domains');
    }

    /**
     * Create a new tenant.
     */
    public function createTenant(array $data): Tenant
    {
        $tenantId = $this->generateUniqueTenantId($data['company_name']);
        $domain = $this->generateUniqueDomain($data['company_name']);

        // Get Demo plan if no subscription_plan_id is provided
        if (!isset($data['subscription_plan_id'])) {
            $demoPlan = SubscriptionPlan::where('name', 'Demo')->first();
            $data['subscription_plan_id'] = $demoPlan?->id;
        }

        $tenant = Tenant::create([
            'id' => $tenantId,
            'company_name' => $data['company_name'],
            'user_id' => $data['user_id'] ?? auth()->id(),
            'subscription_plan_id' => $data['subscription_plan_id'],
        ]);
        
        $tenant->domains()->create(['domain' => $domain]);

        // Run tenant migrations
        $tenant->run(function () {
            \Artisan::call('migrate', [
                '--path' => 'database/migrations/tenant',
                '--force' => true,
            ]);

            // Run tenant seeders
            \Artisan::call('db:seed', [
                '--class' => 'Database\\Seeders\\Tenant\\TenantSeeder',
                '--force' => true,
            ]);
        });

        return $tenant;
    }

    /**
     * Update an existing tenant.
     */
    public function updateTenant(Tenant $tenant, array $data): Tenant
    {
        $tenant->update($data);

        return $tenant->fresh();
    }

    /**
     * Delete a tenant.
     */
    public function deleteTenant(Tenant $tenant): bool
    {
        return $tenant->delete();
    }

    /**
     * Generate a unique tenant ID based on company name.
     */
    protected function generateUniqueTenantId(string $companyName): string
    {
        $tenantId = Str::slug($companyName) . '-' . Str::random(6);

        // Ensure the tenant ID is unique
        while (Tenant::find($tenantId)) {
            $tenantId = Str::slug($companyName) . '-' . Str::random(6);
        }

        return $tenantId;
    }

    /**
     * Generate a unique domain name based on company name.
     */
    protected function generateUniqueDomain(string $companyName): string
    {
        $baseDomain = Str::slug($companyName);
        $tenantDomain = config('tenancy.tenant_domain', 'localhost');
        $domain = $baseDomain . '.' . $tenantDomain;

        // Ensure the domain is unique
        $counter = 1;
        while (\Stancl\Tenancy\Database\Models\Domain::where('domain', $domain)->exists()) {
            $domain = $baseDomain . '-' . $counter . '.' . $tenantDomain;
            $counter++;
        }

        return $domain;
    }
}
