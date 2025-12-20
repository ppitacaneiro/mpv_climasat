<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    // Guest Routes (sin autenticación)
    Route::middleware('guest')->group(function () {
        // Ruta principal del tenant - muestra login
        Route::get('/', [AuthenticatedSessionController::class, 'create'])
            ->name('tenant.home');
        
        // Login
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->name('tenant.login');
        
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->name('tenant.login.store');
    });

    // Authenticated Routes (requieren autenticación)
    Route::middleware('auth')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            return Inertia::render('Tenant/Dashboard', [
                'tenant' => [
                    'id' => tenant('id'),
                    'name' => tenant('name') ?? 'Tenant',
                ],
                'user' => auth()->user(),
            ]);
        })->name('tenant.dashboard');

        // Logout
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('tenant.logout');
    });

    Route::get('/login', [TenantSessionController::class, 'loginForm'])->name('tenant.form.login');
    Route::post('/login', [TenantSessionController::class, 'login'])->name('tenant.login');
});
