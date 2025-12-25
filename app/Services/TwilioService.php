<?php

namespace App\Services;

use App\Models\Tenant\Client;
use App\Models\Tenant;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    use \App\Traits\PhoneNormalization;

    protected \Twilio\Rest\Client $twilio;

    public function __construct() 
    {
        $this->twilio = new \Twilio\Rest\Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    /**
     * Manejar mensaje entrante de WhatsApp
     */
    public function handleIncomingWhatsAppMessage(array $data): array
    {
        $to          = $data['To'];
        $from        = $this->normalizePhone($data['From']);
        $body        = trim($data['Body']);
        $profileName = $data['ProfileName'] ?? 'Nuevo Cliente';

        return [
            'to'          => $to,
            'from'        => $from,
            'body'        => $body,
            'profileName' => $profileName,
        ];
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
            Log::channel('whatsapp_ticket')->error($e->getMessage());
            return false;
        }
    }
}
