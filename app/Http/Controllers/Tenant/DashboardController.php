<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Tenant/Dashboard', [
            'tenant' => [
                'id' => tenant('id'),
                'name' => tenant('name'),
            ],
            'user' => auth()->user(),
        ]);
    }
}
