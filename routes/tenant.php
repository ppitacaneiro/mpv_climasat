<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

use App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\ClientController;
use App\Http\Controllers\Tenant\TechnicianController;
use App\Http\Controllers\Tenant\FaultTypeController;
use App\Http\Controllers\Tenant\TicketController;
use App\Http\Controllers\Tenant\WorkOrderController;
use App\Http\Controllers\Tenant\InvoiceController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Guest Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest')->group(function () {

        Route::get('/', [AuthenticatedSessionController::class, 'create'])
            ->name('tenant.home');

        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->name('tenant.login');

        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->name('tenant.login.store');
    });

    /*
    |--------------------------------------------------------------------------
    | Authenticated Tenant Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('tenant.dashboard');

        // Clientes
        Route::resource('clients', ClientController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        // Técnicos
        Route::resource('technicians', TechnicianController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        // Tipos de Avería
        Route::resource('fault-types', FaultTypeController::class)
            ->only(['index', 'create', 'store', 'edit', 'update']);

        // Tickets
        Route::resource('tickets', TicketController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update']);

        // Partes de Trabajo
        Route::resource('work-orders', WorkOrderController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update']);

        // Facturas
        Route::resource('invoices', InvoiceController::class)
            ->only(['index', 'create', 'store', 'show']);

        // Logout
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('tenant.logout');
    });
});
