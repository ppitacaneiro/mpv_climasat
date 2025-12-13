<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiDiagnosis extends Model
{
    protected $fillable = [
        'ticket_id',
        'suggested_fault_type',
        'suggested_urgency',
        'suggested_solution',
        'confidence_score',
    ];

    protected $casts = [
        'suggested_urgency' => 'string',
        'confidence_score' => 'decimal:2',
    ];

    /**
     * Get the ticket that owns the AI diagnosis.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
