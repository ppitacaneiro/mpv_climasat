<?php

namespace App\Services\Tenant;

use App\Models\Tenant\Technician;
use Illuminate\Support\Facades\DB;

class TechnicianService
{
    public function index($search = null)
    {
        $technicians = Technician::query()
            ->when($search, fn($query) => $query->search($search))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return $technicians;
    }

    public function create(array $data): Technician
    {
        return DB::transaction(function () use ($data) {
            return Technician::create($data);
        });
    }

    public function find(string $id): ?Technician
    {
        return Technician::findOrFail($id);
    }

    public function update(string $id, array $data): Technician
    {
        return DB::transaction(function () use ($id, $data) {
            $technician = Technician::findOrFail($id);
            $technician->update($data);
            return $technician;
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $technician = Technician::findOrFail($id);
            $technician->delete();
        });
    }
}