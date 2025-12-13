<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrder extends Model
{
    protected $fillable = [
        'ticket_id',
        'technician_id',
        'date',
        'materials_used',
        'estimated_time',
        'notes',
        'photos',
    ];

    protected $casts = [
        'date' => 'datetime',
        'materials_used' => 'array',
        'estimated_time' => 'integer',
        'photos' => 'array',
    ];

    /**
     * Get the ticket that owns the work order.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the technician assigned to the work order.
     */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }
}
