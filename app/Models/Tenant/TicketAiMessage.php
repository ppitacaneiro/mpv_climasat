<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Ticket;

class TicketAiMessage extends Model
{
    protected $fillable = [
        'ticket_id',
        'content',
        'role',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
