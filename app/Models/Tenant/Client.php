<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'tax_id',
        'contact',
        'phone',
        'email',
        'address',
        'history',
    ];

    /**
     * Get the tickets for the client.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
