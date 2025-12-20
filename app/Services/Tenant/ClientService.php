<?php

namespace App\Services\Tenant;

use App\Models\Tenant\Client;
use Illuminate\Support\Facades\DB;

class ClientService
{
    public function index($search = null)
    {
        $clients = Client::query()
            ->when($search, fn($query) => $query->search($search))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return $clients;
    }

    public function create(array $data): Client
    {
        return DB::transaction(function () use ($data) {
            return Client::create($data);
        });
    }
}