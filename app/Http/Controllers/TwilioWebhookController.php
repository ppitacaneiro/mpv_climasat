<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use Illuminate\Http\Request;
use App\Http\Requests\TwilioWebhookRequest;

class TwilioWebhookController extends Controller
{
    public function __construct(private TwilioService $twilioService)
    {
    }

    public function handle(TwilioWebhookRequest $request)
    {
        \Log::info('Received Twilio webhook:', $request->all());

        $this->twilioService->handleIncomingWhatsAppMessage($request->validated());
        
        return response('Webhook received', 200);
    }
}
