<?php

namespace App\Services\Tenant;

use App\Models\Tenant\FaultType;

class FaultTypeService {

    public function getAll()
    {
        return FaultType::all();
    }
}