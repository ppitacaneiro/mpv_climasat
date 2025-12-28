<?php

namespace App\Services\Tenant;

use App\Models\Tenant\FaultType;

class FaultTypeService {

    public function getAll()
    {
        return FaultType::all();
    }

    public function index($search = null)
    {
        $faultTypes = FaultType::query()
            ->when($search, fn($query) => $query->search($search))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return $faultTypes;
    }

    public function store(array $data): FaultType
    {
        return FaultType::create($data);
    }

}