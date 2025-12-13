<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\TenantService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __construct(
        protected TenantService $tenantService
    ) {}

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));

            // Create tenant after email verification
            $companyName = session('company_name');
            if ($companyName) {
                $this->tenantService->createTenant([
                    'company_name' => $companyName,
                    'user_id' => $request->user()->id,
                ]);
                session()->forget('company_name');
            }
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
