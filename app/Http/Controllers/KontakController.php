<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KontakController extends Controller
{
    /**
     * Fallback router untuk pengalihan form kontak lama ke 4 modul layanan mandiri
     */
    public function store(Request $request)
    {
        $jenis = $request->input('jenis_pesan');

        $targetRoute = match ($jenis) {
            'pengajuan_surat' => route('pengajuan.surat'),
            'pengaduan'       => route('pengaduan.create'),
            'pertanyaan_umum' => route('pertanyaan-umum.create'),
            'daftar_umkm'     => route('pendaftaran-umkm.create'),
            default           => route('kontak'),
        };

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Silakan lanjutkan melalui modul layanan yang telah dipilih.',
                'redirect' => $targetRoute,
            ]);
        }

        return redirect($targetRoute);
    }
}
