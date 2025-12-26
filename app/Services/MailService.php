<?php

namespace App\Services;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Tenant\Ticket;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class MailService
{
    /**
     * Send tenant setup completion email.
     */
    public function sendTenantSetupEmail(User $user, Tenant $tenant, string $password): void
    {
        $domain = $tenant->domains->first()?->domain;
        
        Mail::send('emails.tenant-setup', [
            'user' => $user,
            'tenant' => $tenant,
            'domain' => $domain,
            'password' => $password,
            'accessUrl' => $domain ? "http://{$domain}" : null,
        ], function (Message $message) use ($user) {
            $message->to($user->email, $user->name)
                    ->subject('Tu espacio de trabajo de ClimaSAT está listo');
        });
    }

    /**
     * Send subscription upgrade notification.
     */
    public function sendSubscriptionUpgradeEmail(User $user, string $planName): void
    {
        Mail::send('emails.subscription-upgrade', [
            'user' => $user,
            'planName' => $planName,
        ], function (Message $message) use ($user) {
            $message->to($user->email, $user->name)
                    ->subject('Plan de suscripción actualizado');
        });
    }

    /**
     * Send invoice email (tenant context).
     */
    public function sendInvoiceEmail(string $clientEmail, string $clientName, array $invoiceData): void
    {
        Mail::send('emails.invoice', $invoiceData, function (Message $message) use ($clientEmail, $clientName) {
            $message->to($clientEmail, $clientName)
                    ->subject('Tu factura - ClimaSAT');
        });
    }

    /**
     * Send ticket notification to tenant administrator (tenant context).
     */
    public function sendTicketOpened(string $adminEmail, string $adminName, Ticket $ticket): void
    {
        $domain = tenant()->domains->first()?->domain;

        Mail::send('emails.ticket-opened', [
            'ticket' => $ticket,
            'adminName' => $adminName,
            'accessUrl' => $domain ? "http://{$domain}/tickets/{$ticket->id}/edit" : null,
        ], function (Message $message) use ($adminEmail, $adminName) {
            $message->to($adminEmail, $adminName)
                    ->subject('Nuevo ticket creado - ClimaSAT');
        });
    }

    /**
     * Send ticket notification to client (tenant context).
     */
    public function sendTicketNotification(string $clientEmail, string $clientName, array $ticketData): void
    {
        Mail::send('emails.ticket-notification', $ticketData, function (Message $message) use ($clientEmail, $clientName) {
            $message->to($clientEmail, $clientName)
                    ->subject('Actualización de aviso - ClimaSAT');
        });
    }

    /**
     * Send ticket assignment to technician (tenant context).
     */
    public function sendTicketAssignmentEmail(string $technicianEmail, string $technicianName, array $ticketData): void
    {
        Mail::send('emails.ticket-assignment', $ticketData, function (Message $message) use ($technicianEmail, $technicianName) {
            $message->to($technicianEmail, $technicianName)
                    ->subject('Nueva asignación de aviso - ClimaSAT');
        });
    }

    /**
     * Send work order completion notification.
     */
    public function sendWorkOrderCompletionEmail(string $clientEmail, string $clientName, array $workOrderData): void
    {
        Mail::send('emails.work-order-completed', $workOrderData, function (Message $message) use ($clientEmail, $clientName) {
            $message->to($clientEmail, $clientName)
                    ->subject('Orden de trabajo completada - ClimaSAT');
        });
    }

    /**
     * Send demo plan expiration warning.
     */
    public function sendDemoPlanExpirationWarning(User $user, int $daysRemaining): void
    {
        Mail::send('emails.demo-expiration', [
            'user' => $user,
            'daysRemaining' => $daysRemaining,
        ], function (Message $message) use ($user) {
            $message->to($user->email, $user->name)
                    ->subject('Tu plan Demo está por expirar');
        });
    }
}
