<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MasyarakatAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu untuk mengakses layanan ini.',
                    'redirect' => route('login')
                ], 401);
            }

            session()->put('url.intended', $request->fullUrl());

            return redirect()->route('login')
                ->with('warning', 'Silakan masuk (login) atau daftar akun warga terlebih dahulu untuk menggunakan layanan masyarakat.');
        }

        return $next($request);
    }
}
