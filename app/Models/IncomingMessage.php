<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingMessage extends Model
{
    protected $fillable = [
        'tenant_id',
        'message_sid',
        'from',
        'to',
        'body',
        'processed_at',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
