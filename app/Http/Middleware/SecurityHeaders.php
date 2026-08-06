<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menambahkan HTTP Security Headers ke setiap response:
 * - Content-Security-Policy (CSP) untuk mencegah XSS
 * - X-Frame-Options untuk mencegah Clickjacking
 * - X-Content-Type-Options untuk mencegah MIME sniffing
 * - Referrer-Policy untuk kontrol data referral
 * - Permissions-Policy untuk membatasi API browser
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ── X-Content-Type-Options ────────────────────────────────────────────
        // Mencegah browser "menebak" tipe konten (MIME sniffing attack)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // ── X-Frame-Options ──────────────────────────────────────────────────
        // Mencegah halaman dimuat dalam iframe dari domain lain (Clickjacking)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // ── X-XSS-Protection ─────────────────────────────────────────────────
        // Header legacy untuk browser lama, tetap berguna
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // ── Referrer-Policy ───────────────────────────────────────────────────
        // Hanya kirim referrer ke same-origin, tidak bocor ke domain luar
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // ── Permissions-Policy ────────────────────────────────────────────────
        // Batasi fitur browser berbahaya yang tidak diperlukan
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // ── Content-Security-Policy (CSP) ────────────────────────────────────
        // Hanya izinkan sumber yang dipercaya untuk script, style, gambar, dll.
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' cdn.jsdelivr.net unpkg.com fonts.googleapis.com",
            "style-src 'self' 'unsafe-inline' fonts.googleapis.com cdn.jsdelivr.net",
            "font-src 'self' fonts.gstatic.com fonts.googleapis.com cdn.jsdelivr.net data:",
            "img-src 'self' data: blob: *.unsplash.com *.google.com *.googleapis.com",
            "frame-src 'self' https://www.google.com https://maps.google.com",
            "connect-src 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
        ]);
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
