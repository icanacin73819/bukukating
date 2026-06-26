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

        $user = Auth::user();

        // Jika admin
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        // Jika mahasiswa masih pending
        if ($user->status === 'pending') {
            return redirect('/waiting-approval');
        }

        // Jika ditolak
        if ($user->status === 'ditolak') {
            Auth::logout();

            return redirect('/login')
                ->withErrors([
                    'email' => 'Akun Anda ditolak oleh Admin.',
                ]);
        }

        // Jika aktif, cek apakah ada parameter redirect di URL
        $redirect = $request->query('redirect');
        
        return redirect()->intended(
            $redirect ? route($redirect) : route('dashboard', absolute: false)
        );
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