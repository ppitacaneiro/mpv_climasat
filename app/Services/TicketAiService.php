<?php

namespace App\Services;

use App\Services\TenantService;
use App\Services\Tenant\ClientService;
use App\Services\Tenant\TicketService;
use App\Services\OpenAIService;
use Illuminate\Support\Facades\Log;

class TicketAiService
{
    public function __construct(
        private TenantService $tenantService,
        private ClientService $clientService,
        private TicketService $ticketService,
        private OpenAIService $openAIService,
        private TwilioService $twilioService
    )
    {
    }

    public function processIncomingWhatsAppMessage(array $payload): void
    {
        $messageData = $this->twilioService->handleIncomingWhatsAppMessage($payload);
        $to          = $messageData['to'];
        $from        = $messageData['from'];
        $body        = $messageData['body'];
        $profileName = $messageData['profileName'];

        $tenant = $this->tenantService->findTenantByTwilioNumber($to);
        if (!$tenant) {
            Log::channel('whatsapp_ticket')->warning("No tenant found for Twilio number: {$to}");
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

            $this->twilioService->sendWhatsAppMessageToClient(
                $client,
                $tenant,
                "Perfecto {$client->name}, pasamos tu caso a un técnico. ¡Gracias!"
            );

            return;
        }

        $this->ticketService->createIaMessage($ticket, 'user', $body);

        $conversation = $this->ticketService->getLastIaMessages($ticket, 10);
        Log::channel('whatsapp_ticket')->info("Contexto conversación para ticket {$ticket->id}:\n{$conversation}");

        $aiResult = $this->openAIService->generarTicketHVAC($conversation);
        Log::channel('whatsapp_ticket')->info("Respuesta IA para ticket {$ticket->id}:\n" . json_encode($aiResult));

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

        $this->twilioService->sendWhatsAppMessageToClient(
            $client,
            $tenant,
            $message
        );
    }
}