@component('mail::message')
# Bienvenido {{ $user->name }}

Gracias por registrarte en {{ config('app.name') }}. Para completar tu registro y activar tu cuenta, necesitamos verificar tu dirección de correo electrónico.

Por favor, haz clic en el siguiente botón para verificar tu cuenta:

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Verificar Mi Cuenta
@endcomponent

Este enlace de verificación expirará en {{ config('auth.verification.expire', 60) }} minutos.

Si no creaste una cuenta en {{ config('app.name') }}, puedes ignorar este correo de forma segura.

Gracias,<br>
{{ config('app.name') }}

@component('mail::subcopy')
Si tienes problemas al hacer clic en el botón "Verificar Mi Cuenta", copia y pega la siguiente URL en tu navegador:
[{{ $url }}]({{ $url }})
@endcomponent
@endcomponent
