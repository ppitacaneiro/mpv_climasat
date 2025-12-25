<?php

namespace App\Http\Controllers;

use App\Http\Requests\TwilioWebhookRequest;
use App\Services\TicketAiService;
use Illuminate\Support\Facades\Log;

class TwilioWebhookController extends Controller
{
    public function __construct(private TicketAiService $ticketAiService)
    {
    }

    // TODO: Agregar verificación de firma de Twilio con custom middleware
    public function handle(TwilioWebhookRequest $request)
    {
        Log::channel('whatsapp_ticket')->info('Received Twilio webhook', $request->all());

        $this->ticketAiService->processIncomingWhatsAppMessage($request->validated());
        
        return response('Webhook received', 200);
    }
}
