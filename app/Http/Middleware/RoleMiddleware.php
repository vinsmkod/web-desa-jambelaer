<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request with role-based authorization.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu.',
                    'redirect' => route('admin.login'),
                ], 401);
            }
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Admin sistem utama selalu memiliki hak akses (super-access)
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Cek apakah role pengguna ada di daftar role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        $allowedLabels = collect($roles)->map(function ($r) {
            return match($r) {
                'staff_desa'        => 'Staff Desa',
                'kasi_pemerintahan' => 'Kasi Pemerintahan',
                'sekretaris_desa'   => 'Sekretaris Desa',
                'kepala_desa'       => 'Kepala Desa',
                default             => ucfirst(str_replace('_', ' ', $r)),
            };
        })->implode(', ');

        $message = "Akses ditolak. Fitur ini hanya dapat diakses oleh: {$allowedLabels}. Anda saat ini masuk sebagai {$user->role_label}.";

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 403);
        }

        abort(403, $message);
    }
}

