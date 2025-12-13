<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'client_id',
        'technician_id',
        'fault_type_id',
        'description',
        'status',
        'urgency',
        'closed_at',
    ];

    protected $casts = [
        'status' => 'string',
        'urgency' => 'string',
        'closed_at' => 'datetime',
    ];

    /**
     * Get the client that owns the ticket.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the technician assigned to the ticket.
     */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }

    /**
     * Get the fault type of the ticket.
     */
    public function faultType(): BelongsTo
    {
        return $this->belongsTo(FaultType::class);
    }

    /**
     * Get the AI diagnoses for the ticket.
     */
    public function aiDiagnoses(): HasMany
    {
        return $this->hasMany(AiDiagnosis::class);
    }

    /**
     * Get the work orders for the ticket.
     */
    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }
}
