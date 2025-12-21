<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use Illuminate\Http\Request;

class TwilioWebhookController extends Controller
{
    public function __construct(private TwilioService $twilioService)
    {
    }

    public function handle(Request $request)
    {
        \Log::info('Received Twilio webhook:', $request->all());

        $this->twilioService->handleIncomingWhatsAppMessage($request->all());
        
        return response('Webhook received', 200);
    }
}
