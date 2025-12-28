<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Tenant\FaultTypeService;
use Inertia\Inertia;
use App\Enums\TicketUrgency;

class FaultTypeController extends Controller
{
    public function __construct(private FaultTypeService $faultTypeService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $faultTypes = $this->faultTypeService->index($request->get('search'));

        return Inertia::render('Tenant/FaultTypes/Index', [
            'faultTypes' => $faultTypes,
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
        return Inertia::render('Tenant/FaultTypes/Create', [
            'priorities' => collect(TicketUrgency::cases())->map(fn ($u) => [
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
