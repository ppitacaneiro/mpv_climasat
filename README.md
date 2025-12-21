# ClimaSAT

Sistema de gestión de avisos y mantenimiento para empresas de climatización con arquitectura multi-tenant.

## Características

- 🏢 **Multi-tenant**: Cada empresa tiene su propio espacio de trabajo aislado
- 👥 **Gestión de clientes y técnicos**
- 🎫 **Sistema de tickets/avisos** con diferentes niveles de urgencia
- 🤖 **Diagnósticos IA** para sugerencias automáticas
- 📋 **Órdenes de trabajo** con seguimiento completo
- 💰 **Facturación integrada** con ítems detallados
- 📧 **Sistema de notificaciones por email**
- 🔐 **Autenticación con verificación de email**
- 📊 **Planes de suscripción** (Demo, Starter, Basic, Pro)

## Tecnologías

- **Backend**: Laravel 11 + PHP 8.2+
- **Frontend**: Vue 3 + Inertia.js + Tailwind CSS
- **Base de datos**: MySQL
- **Multi-tenancy**: stancl/tenancy
- **Email**: Laravel Mail

## Requisitos

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL >= 8.0

## Instalación - Desarrollo

### 1. Clonar el repositorio

```bash
git clone <repository-url>
cd mpv_climasat
```

### 2. Instalar dependencias

```bash
# Dependencias PHP
composer install

# Dependencias JavaScript
npm install
```

### 3. Configurar variables de entorno

```bash
cp .env.example .env
```

Editar `.env` y configurar:

```env
APP_NAME=ClimaSAT
APP_ENV=local
APP_URL=http://localhost:8000

# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=climasat
DB_USERNAME=root
DB_PASSWORD=

# Colas (sync para desarrollo, database/redis para producción)
QUEUE_CONNECTION=sync

# Dominio base para tenants (localhost en desarrollo)
TENANT_DOMAIN=localhost

# Credenciales admin
ADMIN_USERNAME=admin
ADMIN_EMAIL=admin@climasat.com
ADMIN_PASSWORD=tu-contraseña-segura

# Email (usar mailtrap.io o mailhog en desarrollo)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu-usuario
MAIL_PASSWORD=tu-contraseña
MAIL_FROM_ADDRESS="noreply@climasat.com"
```

### 4. Generar clave de aplicación

```bash
php artisan key:generate
```

### 5. Crear base de datos

Crear la base de datos en MySQL:

```sql
CREATE DATABASE climasat CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Ejecutar migraciones y seeders

```bash
# Migraciones centrales y seeders (usuarios, planes, tenants)
php artisan migrate:fresh --seed
```

### 7. Compilar assets

```bash
# Desarrollo (watch mode)
npm run dev
```

### 8. Iniciar servidor

```bash
# En otra terminal
php artisan serve
```

Acceder a: http://localhost:8000

## Comandos de Desarrollo

```bash
# Servidor de desarrollo
php artisan serve

# Watch de assets (hot reload)
npm run dev

# Limpiar cache
php artisan optimize:clear

# Ejecutar tests
php artisan test

# Ver rutas
php artisan route:list

# Refrescar base de datos
php artisan migrate:fresh --seed
```

## Despliegue en Producción

### 1. Variables de entorno

Configurar `.env` para producción:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://climasat.com

# Base de datos
DB_CONNECTION=mysql
DB_HOST=tu-host-produccion
DB_DATABASE=climasat_production
DB_USERNAME=tu-usuario
DB_PASSWORD=tu-contraseña-segura

# Colas (usar database o redis)
QUEUE_CONNECTION=database

# Dominio para tenants
TENANT_DOMAIN=climasat.com

# Email en producción
MAIL_MAILER=smtp
MAIL_HOST=tu-servidor-smtp
MAIL_PORT=587
MAIL_USERNAME=tu-usuario
MAIL_PASSWORD=tu-contraseña
MAIL_FROM_ADDRESS="noreply@climasat.com"

# Cache y sesiones
CACHE_STORE=redis
SESSION_DRIVER=redis
```

### 2. Optimizar aplicación

```bash
# Instalar dependencias de producción
composer install --optimize-autoloader --no-dev

# Compilar assets para producción
npm run build

# Optimizar configuración
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Crear enlace simbólico para storage
php artisan storage:link
```

### 3. Ejecutar migraciones

```bash
php artisan migrate --force
php artisan db:seed --class=SubscriptionPlanSeeder --force
```

### 4. Configurar Worker para colas

Crear un servicio systemd o usar supervisor:

```bash
# Supervisor config: /etc/supervisor/conf.d/climasat-worker.conf
[program:climasat-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/application/artisan queue:work --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/application/storage/logs/worker.log
```

### 5. Configurar Cron

Agregar al crontab:

```bash
* * * * * cd /path/to/application && php artisan schedule:run >> /dev/null 2>&1
```

### 6. Configurar servidor web

#### Nginx

```nginx
server {
    listen 80;
    server_name climasat.com *.climasat.com;
    root /path/to/application/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 7. DNS - Wildcard subdomain

Configurar un registro DNS wildcard para los subdominios de tenants:

```
A    *.climasat.com    -> IP-servidor
```

## Arquitectura Multi-Tenant

- **Base de datos central**: Usuarios, tenants, planes de suscripción
- **Base de datos por tenant**: Clientes, técnicos, tickets, facturas, etc.
- **Dominios**: Cada tenant accede vía subdominio (ej: `empresa.climasat.com`)
- **Aislamiento**: Datos completamente separados entre tenants

## Planes de Suscripción

| Plan | Precio | Técnicos | Avisos/mes | Características |
|------|--------|----------|------------|-----------------|
| Demo | 0€ | 1 | 5 | Prueba gratuita |
| Starter | 15€ | 1 | 20 | App móvil, fotos, historial |
| Basic | 29€ | 3 | 100 | + IA básica, firma digital, KPIs |
| Pro | 49€ | 10 | Ilimitado | + IA avanzada, rutas, integraciones |

## Estructura del Proyecto

```
app/
├── Http/Controllers/
│   ├── Auth/           # Autenticación
│   └── TenantController.php
├── Models/
│   ├── Tenant/         # Modelos de tenant
│   ├── User.php
│   ├── Tenant.php
│   └── SubscriptionPlan.php
├── Services/
│   ├── TenantService.php
│   └── MailService.php
└── Jobs/
    └── CreateTenantJob.php

database/
├── migrations/
│   ├── tenant/         # Migraciones de tenant
│   └── ...             # Migraciones centrales
└── seeders/
    ├── Tenant/
    └── ...

resources/
├── js/
│   ├── Pages/
│   └── Components/
└── views/
```

## Testing

```bash
# Ejecutar todos los tests
php artisan test

# Con cobertura
php artisan test --coverage
```

## Configuración básica Twilio y ngrok (desarrollo local)

- Para pruebas locales con WhatsApp:

# Twilio:

- ** Regístrate y crea un Sandbox de WhatsApp.
- ** Obtén Account SID y Auth Token.
- ** Anota tu número de Sandbox: whatsapp:+14155238886.
- ** Vincula tu WhatsApp de pruebas siguiendo las instrucciones del Sandbox.

# Ngrok:

- Instala ngrok y ejecuta:

```bash
php artisan serve
ngrok http 8000
```

Obtendrás una URL pública tipo https://xyz.ngrok-free.dev.

Configura esta URL en el Sandbox de WhatsApp como webhook:

When a message comes in (POST):
https://xyz.ngrok-free.dev/twilio/webhook

## Creación de Demo tenant

- php artisan app:create-demo-tenant