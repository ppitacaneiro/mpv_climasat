<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreTechnicianRequest;
use App\Services\Tenant\TechnicianService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class TechnicianController extends Controller
{
    public function __construct(private TechnicianService $technicianService) {}

    public function index(Request $request)
    {
        $technicians = $this->technicianService->index($request->get('search'));

        return Inertia::render('Tenant/Technicians/Index', [
            'technicians' => $technicians,
            'filters' => ['search' => $request->get('search')],
            'tenant' => ['id' => tenant('id'), 'name' => tenant('name')],
            'user' => auth()->user(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Tenant/Technicians/Create', [
            'tenant' => ['id' => tenant('id'), 'name' => tenant('name')],
            'user' => auth()->user(),
        ]);
    }

    public function store(StoreTechnicianRequest $request)
    {
        try {
            $this->technicianService->create($request->validated());
            return redirect()->route('technicians.index')
                ->with('success', 'Técnico creado correctamente.');
        } catch (\Throwable $e) {
            Log::error('Error al crear técnico', [
                'exception' => $e,
                'tenant' => tenant('id'),
                'user_id' => auth()->id(),
                'payload' => $request->validated(),
            ]);

            return back()->withErrors(['general' => 'No se pudo crear el técnico.'])->withInput();
        }
    }

    public function edit(string $id)
    {
        return Inertia::render('Tenant/Technicians/Edit', [
            'technician' => $this->technicianService->find($id),
            'tenant' => ['id' => tenant('id'), 'name' => tenant('name')],
            'user' => auth()->user(),
        ]);
    }

    public function update(StoreTechnicianRequest $request, string $id)
    {
        try {
            $this->technicianService->update($id, $request->validated());
            return redirect()->route('technicians.index')
                ->with('success', 'Técnico actualizado correctamente.');
        } catch (\Throwable $e) {
            Log::error('Error al actualizar técnico', [
                'exception' => $e,
                'tenant' => tenant('id'),
                'user_id' => auth()->id(),
                'payload' => $request->validated(),
                'technician_id' => $id,
            ]);

            return back()->withErrors(['general' => 'No se pudo actualizar el técnico.'])->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->technicianService->delete($id);
            return redirect()->route('technicians.index')
                ->with('success', 'Técnico eliminado correctamente.');
        } catch (\Throwable $e) {
            Log::error('Error al eliminar técnico', [
                'exception' => $e,
                'tenant' => tenant('id'),
                'user_id' => auth()->id(),
                'technician_id' => $id,
            ]);

            return back()->withErrors(['general' => 'No se pudo eliminar el técnico.']);
        }
    }
}
