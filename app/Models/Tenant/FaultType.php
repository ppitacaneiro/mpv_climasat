<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\TicketUrgency;

class FaultType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'priority',
    ];

    protected $casts = [
        'priority' => TicketUrgency::class,
    ];

    protected $appends = [
        'priority_label'
    ];

    public function getPriorityLabelAttribute(): string
    {
        return $this->priority->label();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('priority', 'like', "%{$search}%");
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the tickets of this fault type.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
