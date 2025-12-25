<?php

namespace App\Services;

use App\Services\TenantService;
use App\Services\Tenant\ClientService;
use App\Services\Tenant\TicketService;
use App\Models\Tenant\Client;
use App\Models\Tenant\TicketAiMessage;
use App\Models\Tenant;
use App\Services\OpenAIService;

class TwilioService
{
    use \App\Traits\PhoneNormalization;

    protected \Twilio\Rest\Client $twilio;

    public function __construct(
        private TenantService $tenantService,
        private ClientService $clientService,
        private TicketService $ticketService,
        private OpenAIService $openAIService,
        private IncomingMessageService $incomingMessageService
    ) {
        $this->twilio = new \Twilio\Rest\Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function handleIncomingWhatsAppMessage(array $payload): void
    {
        $to          = $payload['To'];
        $from        = $this->normalizePhone($payload['From']);
        $body        = trim($payload['Body']);
        $profileName = $payload['ProfileName'] ?? 'Nuevo Cliente';

        $tenant = $this->tenantService->findTenantByTwilioNumber($to);
        if (!$tenant) {
            \Log::channel('whatsapp_ticket')->warning("No tenant found for Twilio number: {$to}");
            return;
        }

        tenancy()->initialize($tenant);

        $client = $this->clientService->findByPhone($from);
        if (!$client) {
            $client = $this->clientService->create([
                'name'  => $profileName,
                'phone' => $from,
            ]);
        }

        $ticket = $this->ticketService->getOpenTicketForClient($client);
        if (!$ticket) {
            $ticket = $this->ticketService->create([
                'client_id'   => $client->id,
                'description' => $body,
                'status'      => 'open',
                'urgency'     => 'medium',
            ]);
        }

        if (strtolower($body) === 'terminar') {
            $ticket->update(['status' => 'in_progress']);

            $this->sendWhatsAppMessageToClient(
                $client,
                $tenant,
                "Perfecto {$client->name}, pasamos tu caso a un técnico. ¡Gracias!"
            );

            return;
        }

        $this->ticketService->createIaMessage($ticket, 'user', $body);

        $conversation = $this->ticketService->getLastIaMessages($ticket, 10);
        \Log::channel('whatsapp_ticket')->info("Contexto conversación para ticket {$ticket->id}:\n{$conversation}");

        $aiResult = $this->openAIService->generarTicketHVAC($conversation);
        \Log::channel('whatsapp_ticket')->info("Respuesta IA para ticket {$ticket->id}:\n" . json_encode($aiResult));

        $this->ticketService->createIaMessage($ticket, 'assistant', $aiResult['pregunta_siguiente'] ?? 'Diagnóstico completo');
        
        if ($aiResult['pregunta_siguiente'] === null) {
            $ticket->update(['status' => 'in_progress']);

            $message = "Gracias {$client->name}, ya tenemos la información necesaria. "
                        . "Un técnico se pondrá en contacto contigo en breve.";
        } else {
            $message = "Hola {$client->name}, para ayudarte mejor necesito saber lo siguiente:\n\n"
                        . $aiResult['pregunta_siguiente']
                        . "\n\n✋ Puedes escribir *terminar* en cualquier momento.";
        }

        $this->sendWhatsAppMessageToClient($client, $tenant, $message);
    }

    /**
     * Enviar mensaje de WhatsApp
     */
    public function sendWhatsAppMessageToClient(Client $client, Tenant $tenant, string $message): bool
    {
        try {
            $this->twilio->messages->create(
                'whatsapp:+' . $client->phone,
                [
                    'from' => 'whatsapp:' . $tenant->twilio_number,
                    'body' => $message,
                ]
            );

            return true;
        } catch (\Throwable $e) {
            \Log::channel('whatsapp_ticket')->error($e->getMessage());
            return false;
        }
    }
}
