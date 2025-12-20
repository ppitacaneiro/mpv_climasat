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

    public function find(string $id): ?Client
    {
        return Client::findOrFail($id);
    }

    public function update(string $id, array $data): Client
    {
        return DB::transaction(function () use ($id, $data) {
            $client = Client::findOrFail($id);
            $client->update($data);
            return $client;
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $client = Client::findOrFail($id);
            $client->delete();
        });
    }
}