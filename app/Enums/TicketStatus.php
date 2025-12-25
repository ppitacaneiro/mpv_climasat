<?php

namespace App\Enums;

// TODO: Implement ticket status avoiding hardcoded strings in the codebase, including migrations and seeders.
enum TicketStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case CLOSED = 'closed';

    public function label(): string    {
        return match ($this) {
            self::OPEN => 'Abierto',
            self::IN_PROGRESS => 'En progreso',
            self::CLOSED => 'Cerrado',
        };
    }
}