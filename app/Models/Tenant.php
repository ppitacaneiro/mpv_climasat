<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $fillable = [
        'id',
        'company_name',
        'user_id',
        'subscription_plan_id',
        'twilio_number',
    ];

    /**
     * Get custom columns that should be stored as actual columns
     * instead of in the data JSON column.
     */
    public static function getCustomColumns(): array
    {
        return array_merge(parent::getCustomColumns(), [
            'company_name',
            'user_id',
            'subscription_plan_id',
            'twilio_number',
        ]);
    }

    /**
     * Get the user that owns the tenant.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription plan for the tenant.
     */
    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}