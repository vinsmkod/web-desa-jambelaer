<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman dashboard ini hanya dapat diakses oleh Administrator.');
        }

        // Durasi timeout tidak aktif dalam menit (Default: 15 menit)
        $timeoutMinutes = (int) env('ADMIN_SESSION_TIMEOUT', 15);
        $timeoutSeconds = $timeoutMinutes * 60;
        $lastActivity   = session('admin_last_activity');

        if ($lastActivity && (time() - $lastActivity) > $timeoutSeconds) {
            Auth::logout();
            $request->session()->forget('admin_last_activity');
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', "Sesi Anda telah berakhir karena tidak aktif selama {$timeoutMinutes} menit. Silakan login kembali.");
        }

        // Perbarui waktu aktivitas terakhir untuk request ini
        session(['admin_last_activity' => time()]);

        return $next($request);
    }
}
