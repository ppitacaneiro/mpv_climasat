<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'notice_limit',
        'technician_limit',
        'features',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'notice_limit' => 'integer',
        'technician_limit' => 'integer',
        'features' => 'array',
    ];

    /**
     * Get the tenants that belong to this subscription plan.
     */
    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }
}
