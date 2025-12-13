<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Technician extends Model
{
    protected $fillable = [
        'name',
        'tax_id',
        'specialty',
        'phone',
        'email',
        'availability',
    ];

    protected $casts = [
        'availability' => 'string',
    ];

    /**
     * Get the tickets assigned to the technician.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the work orders assigned to the technician.
     */
    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }
}
