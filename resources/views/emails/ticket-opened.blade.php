<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu espacio de trabajo está listo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            background: #ffffff;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .credentials-box {
            background: #f3f4f6;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .credentials-box h3 {
            margin-top: 0;
            color: #2563eb;
        }
        .credential-item {
            margin: 10px 0;
        }
        .credential-label {
            font-weight: bold;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
        }
        .credential-value {
            font-size: 16px;
            color: #111827;
            font-family: 'Courier New', monospace;
            background: white;
            padding: 8px 12px;
            border-radius: 4px;
            margin-top: 5px;
            word-break: break-all;
        }
        .button {
            display: inline-block;
            background: #3b82f6;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background: #2563eb;
        }
        .warning {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            border-radius: 0 0 10px 10px;
        }
        .next-steps {
            background: #eff6ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .next-steps h3 {
            color: #1e40af;
            margin-top: 0;
        }
        .next-steps ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .next-steps li {
            margin: 8px 0;
        }
        .ticket-box {
            background: #f3f4f6;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .ticket-item {
            margin: 10px 0;
        }
        .ticket-label {
            font-weight: bold;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
        }
        .ticket-value {
            font-size: 16px;
            color: #111827;
            margin-top: 5px;
        }
        .badge {
            display: inline-block;
            background: #e0f2fe;
            color: #0284c7;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🆕 Nuevo ticket creado</h1>
    </div>

    <div class="content">
        <p>Hola <strong>{{ $adminName }}</strong>,</p>

        <p>Se ha creado un nuevo ticket en tu espacio de trabajo.</p>

        <div class="ticket-box">
            <div class="ticket-item">
                <div class="ticket-label">Cliente</div>
                <div class="ticket-value">{{ $ticket->client->name }}</div>
            </div>

            <div class="ticket-item">
                <div class="ticket-label">Tipo de avería</div>
                <div class="ticket-value">{{ $ticket->faultType->name ?? '-' }}</div>
            </div>

            <div class="ticket-item">
                <div class="ticket-label">Urgencia</div>
                <div class="ticket-value">
                    <span class="badge">{{ ucfirst($ticket->urgency->label()) }}</span>
                </div>
            </div>

            <div class="ticket-item">
                <div class="ticket-label">Estado</div>
                <div class="ticket-value">{{ ucfirst($ticket->status->label()) }}</div>
            </div>

            <div class="ticket-item">
                <div class="ticket-label">Descripción</div>
                <div class="ticket-value">{{ $ticket->description }}</div>
            </div>

            @if($ticket->suggested_ia_solution)
            <div class="ticket-item">
                <div class="ticket-label">💡 Sugerencia IA</div>
                <div class="ticket-value">{{ $ticket->suggested_ia_solution }}</div>
            </div>
            @endif
        </div>

        @if($accessUrl)
        <center>
            <a href="{{ $accessUrl }}" class="button">Ver ticket</a>
        </center>
        @endif

        <p>Accede al sistema para gestionar este ticket.</p>

        <p>Saludos,<br>
        <strong>El equipo de ClimaSAT</strong></p>
    </div>

    <div class="footer">
        <p>ClimaSAT © {{ date('Y') }} · Sistema de Gestión HVAC<br>
        Este es un correo automático, por favor no respondas a este mensaje.</p>
    </div>
</body>
</html>
