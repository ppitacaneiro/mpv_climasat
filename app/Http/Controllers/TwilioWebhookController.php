<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwilioWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Handle the incoming Twilio webhook request
        // You can access the request data using $request->input('parameter_name')

        // For example, log the incoming data
        \Log::info('Received Twilio webhook:', $request->all());

        // Respond to Twilio to acknowledge receipt
        return response('Webhook received', 200);
    }
}
