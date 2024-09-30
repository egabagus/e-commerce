<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role;

            // Cek jika pengguna memiliki salah satu role yang diizinkan
            foreach ($roles as $role) {
                if ($userRole == $role) {
                    return $next($request);
                }
            }

            // Jika role adalah admin tetapi tidak diizinkan, logout dan redirect
            if ($userRole === 'admin') {
                // Opsional: Redirect admin ke halaman lain jika perlu
                return redirect()->route('dashboard')->with('status', 'Welcome, Admin.');
            }
        }

        Auth::logout();
        return redirect()->route('login')->with('status', 'You are not authorized to access this page.');
    }
}
