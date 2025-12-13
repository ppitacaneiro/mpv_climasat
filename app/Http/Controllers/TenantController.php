<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Services\TenantService;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function __construct(
        protected TenantService $tenantService
    ) {}

    /**
     * Display a listing of the tenants.
     */
    public function index()
    {
        $tenants = $this->tenantService->getPaginatedTenants();
        
        return inertia('Tenants/Index', [
            'tenants' => $tenants,
        ]);
    }

    /**
     * Show the form for creating a new tenant.
     */
    public function create()
    {
        return inertia('Tenants/Create');
    }

    /**
     * Store a newly created tenant in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $tenant = $this->tenantService->createTenant($validated);

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant created successfully.');
    }

    /**
     * Display the specified tenant.
     */
    public function show(Tenant $tenant)
    {
        $tenant = $this->tenantService->getTenantWithRelations($tenant);
        
        return inertia('Tenants/Show', [
            'tenant' => $tenant,
        ]);
    }

    /**
     * Show the form for editing the specified tenant.
     */
    public function edit(Tenant $tenant)
    {
        return inertia('Tenants/Edit', [
            'tenant' => $tenant,
        ]);
    }

    /**
     * Update the specified tenant in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $tenant = $this->tenantService->updateTenant($tenant, $validated);

        return redirect()->route('tenants.show', $tenant)
            ->with('success', 'Tenant updated successfully.');
    }

    /**
     * Remove the specified tenant from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $this->tenantService->deleteTenant($tenant);

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant deleted successfully.');
    }
}
