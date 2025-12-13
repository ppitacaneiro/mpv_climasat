<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaultType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'priority',
    ];

    protected $casts = [
        'priority' => 'string',
    ];

    /**
     * Get the tickets of this fault type.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
