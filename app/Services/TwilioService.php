<?php

namespace App\Services;

use App\Services\TenantService;
use App\Services\Tenant\ClientService;
use App\Services\Tenant\TicketService;
use App\Models\Tenant\Client;
use App\Models\Tenant;

class TwilioService
{
    use \App\Traits\PhoneNormalization;

    protected $client;

    public function __construct(
        private TenantService $tenantService,
        private ClientService $clientService,
        private TicketService $ticketService
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

        $ticketData = [
            'client_id'  => $client->id,
            'description'=> $body,
            'status'     => 'open',
            'urgency'    => 'medium',
        ];
        $this->ticketService->create($ticketData);
        \Log::info("Created new ticket for client: {$client->id} in tenant: {$tenant->id}");

        $message = "Hola {$client->name}, hemos recibido tu mensaje y hemos creado un ticket para ti. Nos pondremos en contacto pronto.";
        $sent = $this->sendWhatsAppMessageToClient($client, $tenant, $message);

        if (!$sent) {
            \Log::warning("El mensaje a {$client->phone} no se pudo enviar, revisar Twilio o configuración del tenant {$tenant->id}");
        } else {
            \Log::info("Mensaje enviado correctamente a {$client->phone}");
        }

    }   

    /**
     * Enviar mensaje de WhatsApp a un cliente
     *
     * @param Client $client
     * @param string $message
     * @param string|null $from Número Twilio del tenant, si no se pasa se toma el default
     * @return void
     */
    public function sendWhatsAppMessageToClient(Client $client, Tenant $tenant, string $message): bool
    {
        $toNumber = 'whatsapp:+' . $client->phone;
        $fromNumber = 'whatsapp:' . $tenant->twilio_number; 

        try {        
            $this->client->messages->create(
                $toNumber,
                [
                    'from' => $fromNumber,
                    'body' => $message,
                ]
            );

            \Log::info("Sent WhatsApp message to client {$client->id}", [
                'to' => $toNumber,
                'from' => $fromNumber,
                'body' => $message,
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error("Failed to send WhatsApp message to {$toNumber} from number {$fromNumber}: " . $e->getMessage());
            return false;
        }
    }
}