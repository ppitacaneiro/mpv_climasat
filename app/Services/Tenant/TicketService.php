<?php

namespace App\Services\Tenant;

use App\Models\Tenant\Ticket;
use App\Models\Tenant\Client;
use App\Models\Tenant\Technician;
use App\Models\Tenant\FaultType;
use Illuminate\Support\Collection;
use App\Models\Tenant\TicketAiMessage;

class TicketService
{
    public function index(?string $search = null)
    {
        $tickets = Ticket::query()
            ->with(['client', 'technician', 'faultType'])
            ->when($search, fn($query) => $query->search($search))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return $tickets;
    }

    /**
     * Crear un nuevo ticket
     *
     * @param array $data
     * @return Ticket
     */
    public function create(array $data): Ticket
    {
        return Ticket::create([
            'client_id' => $data['client_id'],
            'technician_id' => $data['technician_id'] ?? null,
            'fault_type_id' => $data['fault_type_id'] ?? null,
            'description' => $data['description'] ?? '',
            'status' => $data['status'] ?? 'open',
            'urgency' => $data['urgency'] ?? 'medium',
        ]);
    }

    /**
     * Actualizar un ticket existente
     *
     * @param Ticket $ticket
     * @param array $data
     * @return Ticket
     */
    public function update(Ticket $ticket, array $data): Ticket
    {
        $ticket->update($data);
        return $ticket;
    }

    /**
     * Buscar ticket por ID
     *
     * @param int $id
     * @return Ticket|null
     */
    public function findById(int $id): ?Ticket
    {
        return Ticket::find($id);
    }

    /**
     * Obtener tickets de un cliente
     *
     * @param Client $client
     * @return Collection
     */
    public function getByClient(Client $client): Collection
    {
        return $client->tickets()->get();
    }

    /**
     * Asignar técnico a un ticket
     *
     * @param Ticket $ticket
     * @param Technician $technician
     * @return Ticket
     */
    public function assignTechnician(Ticket $ticket, Technician $technician): Ticket
    {
        $ticket->technician()->associate($technician);
        $ticket->save();
        return $ticket;
    }

    /**
     * Cerrar un ticket
     *
     * @param Ticket $ticket
     * @return Ticket
     */
    public function close(Ticket $ticket): Ticket
    {
        $ticket->status = 'closed';
        $ticket->closed_at = now();
        $ticket->save();
        return $ticket;
    }

    /**
     * Obtener ticket abierto de un cliente
     *
     * @param Client $client
     * @return Ticket|null
     */
    public function getOpenTicketForClient(Client $client): ?Ticket
    {
        return $client->tickets()->where('status', 'open')->first();
    }

    /**
     * Crear mensaje IA para un ticket
     *
     * @param Ticket $ticket
     * @param string $role
     * @param string $content
     * @return TicketAiMessage
     */
    public function createIaMessage(Ticket $ticket, string $role, string $content)
    {
        return TicketAiMessage::create([
            'ticket_id' => $ticket->id,
            'role'      => $role,
            'content'   => $content,
        ]);
    }

    /**
     * Obtener últimos mensajes IA de un ticket
     *
     * @param Ticket $ticket
     * @param int $limit
     * @return string
     */
    public function getLastIaMessages(Ticket $ticket, int $limit = 10)
    {
        return TicketAiMessage::where('ticket_id', $ticket->id)
            ->orderBy('id')
            ->limit($limit)
            ->get()
            ->map(fn ($m) => "{$m->role}: {$m->content}")
            ->implode("\n");
    }
}
