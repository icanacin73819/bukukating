<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        // Admin selalu boleh lewat
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Pending → ke waiting approval
        if ($user->status === 'pending') {
            // Kalau sudah di halaman waiting-approval, biarkan lewat
            if ($request->routeIs('waiting-approval')) {
                return $next($request);
            }
            return redirect()->route('waiting-approval');
        }

        // Ditolak → logout paksa
        if ($user->status === 'ditolak') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->withErrors([
                'email' => 'Akun Anda ditolak oleh Admin.',
            ]);
        }

        return $next($request);
    }
}