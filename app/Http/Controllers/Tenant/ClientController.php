<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Client;
use Inertia\Inertia;
use App\Http\Requests\Tenant\StoreClientRequest;
use App\Services\Tenant\ClientService;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function __construct(private ClientService $clientService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = $this->clientService->index($request->get('search'));

        return Inertia::render('Tenant/Clients/Index', [
            'clients' => $clients,
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
        return Inertia::render('Tenant/Clients/Create', [
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
    public function store(StoreClientRequest $request)
    {
        try {
            $data = $request->validated();

            $this->clientService->create($data);

            return redirect()
                ->route('clients.index')
                ->with('success', 'Cliente creado correctamente.');

        } catch (Throwable $e) {

            Log::error('Error al crear cliente', [
                'exception' => $e,
                'tenant' => tenant('id'),
                'user_id' => auth()->id(),
                'payload' => $request->validated(),
            ]);

            return back()
                ->withErrors([
                    'general' => 'No se pudo crear el cliente. Inténtalo de nuevo.',
                ])
                ->withInput();
        }
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
