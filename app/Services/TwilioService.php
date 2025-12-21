<?php

namespace App\Services;

use App\Services\TenantService;
use App\Services\Tenant\ClientService;

class TwilioService
{
    use \App\Traits\PhoneNormalization;

    protected $client;

    public function __construct(
        private TenantService $tenantService,
        private ClientService $clientService
    )
    {
        $this->client = new \Twilio\Rest\Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function handleIncomingWhatsAppMessage(array $payload): void
    {
        $to = $payload['To'];
        $from = $this->normalizePhone($payload['From']);
        $body = $payload['Body'];
        $profileName = $payload['ProfileName'] ?? 'Nuevo Cliente';
        
        $tenant = $this->tenantService->findTenantByTwilioNumber($to);
        if (!$tenant) {
            \Log::warning("No tenant found for Twilio number: $to");
            return;
        }

        tenancy()->initialize($tenant);

        $client = $this->clientService->findByPhone($from);
        \Log::info("Searching for client with phone: $from");
        if (!$client) {
            $clientData = [
                'name'  => $profileName,
                'phone' => $from,
            ];
            $client = $this->clientService->create($clientData);
            \Log::info("Created new client: {$client->id} for tenant: {$tenant->id}");
        }
    }   
}