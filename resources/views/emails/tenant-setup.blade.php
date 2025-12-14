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
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 ¡Tu espacio de trabajo está listo!</h1>
    </div>
    
    <div class="content">
        <p>Hola <strong>{{ $user->name }}</strong>,</p>
        
        <p>Tu espacio de trabajo de <strong>ClimaSAT</strong> ha sido configurado exitosamente para <strong>{{ $tenant->company_name }}</strong>.</p>
        
        <div class="credentials-box">
            <h3>📋 Tus Credenciales de Acceso</h3>
            
            <div class="credential-item">
                <div class="credential-label">URL de Acceso</div>
                <div class="credential-value">{{ $accessUrl ?? 'Pendiente de configuración' }}</div>
            </div>
            
            <div class="credential-item">
                <div class="credential-label">Usuario / Email</div>
                <div class="credential-value">{{ $user->email }}</div>
            </div>
            
            <div class="credential-item">
                <div class="credential-label">Contraseña</div>
                <div class="credential-value">{{ $password }}</div>
            </div>
        </div>

        <div class="warning">
            <strong>⚠️ Importante:</strong> Por tu seguridad, te recomendamos cambiar tu contraseña después de tu primer inicio de sesión. Esta es una contraseña temporal generada automáticamente.
        </div>

        @if($accessUrl)
        <center>
            <a href="{{ $accessUrl }}" class="button">Acceder a mi espacio de trabajo</a>
        </center>
        @endif

        <div class="next-steps">
            <h3>🚀 Próximos Pasos</h3>
            <ul>
                <li>Inicia sesión con las credenciales proporcionadas</li>
                <li>Cambia tu contraseña temporal por una segura</li>
                <li>Configura tu perfil y preferencias</li>
                <li>Agrega técnicos y clientes a tu sistema</li>
                <li>Comienza a gestionar tus avisos HVAC</li>
            </ul>
        </div>

        <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.</p>
        
        <p>Saludos,<br>
        <strong>El equipo de ClimaSAT</strong></p>
    </div>
    
    <div class="footer">
        <p>ClimaSAT © {{ date('Y') }}. Sistema de Gestión HVAC<br>
        Este es un correo automático, por favor no respondas a este mensaje.</p>
    </div>
</body>
</html>
