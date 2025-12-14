<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a ClimaSAT</title>
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
        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            border-radius: 0 0 10px 10px;
        }
        .feature-list {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .feature-list h3 {
            color: #2563eb;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>¡Bienvenido a ClimaSAT!</h1>
    </div>
    
    <div class="content">
        <p>Hola <strong>{{ $user->name }}</strong>,</p>
        
        <p>¡Gracias por registrarte en <strong>ClimaSAT</strong>! Estamos encantados de tenerte con nosotros.</p>
        
        <p>Tu cuenta ha sido creada exitosamente para <strong>{{ $tenant->company_name }}</strong>.</p>

        <div class="feature-list">
            <h3>¿Qué puedes hacer con ClimaSAT?</h3>
            <ul>
                <li>📋 Gestionar avisos HVAC de forma automática</li>
                <li>🤖 Clasificación inteligente con IA</li>
                <li>👥 Asignar técnicos y optimizar rutas</li>
                <li>📱 App móvil para técnicos</li>
                <li>📊 Reportes y KPIs en tiempo real</li>
            </ul>
        </div>

        <p>Pronto recibirás otro correo con las credenciales de acceso a tu espacio de trabajo.</p>
        
        @if($domain)
        <center>
            <a href="http://{{ $domain }}" class="button">Visitar mi Espacio</a>
        </center>
        @endif

        <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
        
        <p>Saludos,<br>
        <strong>El equipo de ClimaSAT</strong></p>
    </div>
    
    <div class="footer">
        <p>ClimaSAT © {{ date('Y') }}. Sistema de Gestión HVAC</p>
    </div>
</body>
</html>
