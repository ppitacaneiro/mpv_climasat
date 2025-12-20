<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Tenant\UserService;
use Inertia\Inertia;

class TenantSessionController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function loginForm()
    {
        return Inertia::render('Tenant/Auth/Login',[
            'companyName' => tenant('company_name'),
        ]);
    }

    public function login(Request $request)
    {
        // Lógica de autenticación del usuario del tenant
    }
}
