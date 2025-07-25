<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Dapatkan user yang sedang login
        $user = Auth::user();

        // Periksa apakah peran user sesuai dengan peran yang diminta di route
        if ($user->role !== $role) {
            // Jika tidak sesuai, redirect ke dashboard default atau halaman unauthorized
            return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            // Atau, Anda bisa membuat halaman error 403 (Forbidden)
            // abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
