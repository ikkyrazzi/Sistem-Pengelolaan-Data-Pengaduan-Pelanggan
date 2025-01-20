<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Cek peran pengguna dan arahkan ke dashboard yang sesuai
        if (Auth::user()->hasRole('Admin')) {
            return redirect()->intended(route('admin.dashboard'));
        } elseif (Auth::user()->hasRole('Customer')) {
            return redirect()->intended(route('customer.dashboard'));
        } elseif (Auth::user()->hasRole('Technician')) {
            return redirect()->intended(route('technician.dashboard'));
        }

        // Jika tidak ada peran yang sesuai, arahkan ke dashboard default
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
