<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\TicketStatus;
use App\Enums\TicketUrgency;
use Illuminate\Database\Eloquent\Builder;

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
        'suggested_ia_solution',
        'technician_solution',
    ];

    protected $casts = [
        'status' => TicketStatus::class,
        'urgency' => TicketUrgency::class,
        'closed_at' => 'datetime',
    ];

    protected $appends = [
        'status_label',
        'urgency_label'
    ];

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function getUrgencyLabelAttribute(): string
    {
        return $this->urgency->label();
    }

    /**
     * Scope: búsqueda global de tickets
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('description', 'like', "%{$search}%")
            ->orWhereHas('client', function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
                $q->orWhere('phone', 'like', "%{$search}%");
            })
            ->orWhereHas('technician', function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('faultType', function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        });
    }

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

    /**
     * Get the invoices for the ticket.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the AI messages for the ticket.
     */
    public function aiMessages(): HasMany
    {
        return $this->hasMany(TicketAiMessage::class);
    }
}
