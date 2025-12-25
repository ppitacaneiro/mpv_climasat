<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Ticket;
use App\Services\Tenant\TicketService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Tenant\Client;
use App\Models\Tenant\FaultType;
use App\Enums\TicketStatus;
use App\Enums\TicketUrgency;

class TicketController extends Controller
{
    public function __construct(private TicketService $ticketService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tickets = $this->ticketService->index($request->get('search'));

        return Inertia::render('Tenant/Tickets/Index', [
            'tickets' => $tickets,
            'filters' => [
                'search' => $request->get('search'),
            ],
            'tenant' => [
                'id' => tenant('id'),
                'name' => tenant('name'),
            ],
            'user' => auth()->user(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tenant/Tickets/Create', [
            'clients' => Client::select('id', 'name')->get(),
            'faultTypes' => FaultType::select('id', 'name')->get(),
            'statuses' => collect(TicketStatus::cases())->map(fn ($s) => [
                'value' => $s->value,
                'label' => $s->label(),
            ]),
            'urgencies' => collect(TicketUrgency::cases())->map(fn ($u) => [
                'value' => $u->value,
                'label' => $u->label(),
            ]),
            'tenant' => [
                'id' => tenant('id'),
                'name' => tenant('name'),
            ],
            'user' => auth()->user(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
