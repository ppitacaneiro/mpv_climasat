<?php

namespace App\Services;
use App\Models\IncomingMessage;

class IncomingMessageService
{
    public function isProcessed(string $messageSid): bool
    {
        return IncomingMessage::where('message_sid', $messageSid)->exists();
    }

    public function markAsProcessed(int $tenantId,
        string $messageSid,
        string $from,
        string $to,
        string $body): bool
    {
        try {
            IncomingMessage::create([
                'tenant_id'   => $tenantId,
                'message_sid' => $messageSid,
                'from'        => $from,
                'to'          => $to,
                'body'        => $body,
                'processed_at'=> now(),
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::channel('whatsapp_ticket')->error("Failed to mark message as processed: " . $e->getMessage());
            return false;
        }
    }
}