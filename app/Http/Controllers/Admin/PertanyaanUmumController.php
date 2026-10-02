<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PertanyaanUmum;
use Illuminate\Http\Request;

class PertanyaanUmumController extends Controller
{
    /**
     * Tampilkan daftar pertanyaan umum masyarakat (SRS-F-012).
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'semua');
        $search = $request->get('q');

        $query = PertanyaanUmum::with('user')->latest();

        $stats = [
            'total'    => PertanyaanUmum::count(),
            'diajukan' => PertanyaanUmum::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'dijawab'  => PertanyaanUmum::where('status', 'dijawab')->count(),
            'selesai'  => PertanyaanUmum::where('status', 'selesai')->count(),
        ];

        if ($status && $status !== 'semua') {
            if ($status === 'diajukan') {
                $query->whereIn('status', ['diajukan', 'menunggu']);
            } else {
                $query->where('status', $status);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pertanyaan', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('subjek', 'like', "%{$search}%")
                  ->orWhere('pertanyaan', 'like', "%{$search}%");
            });
        }

        $pertanyaan = $query->paginate(10)->withQueryString();

        return view('admin.pertanyaan-umum.index', compact('pertanyaan', 'stats', 'status', 'search'));
    }

    /**
     * Tampilkan detail pertanyaan dan form respon jawaban.
     */
    public function show(PertanyaanUmum $pertanyaanUmum)
    {
        $pertanyaanUmum->load('user');
        return view('admin.pertanyaan-umum.show', compact('pertanyaanUmum'));
    }

    /**
     * Berikan jawaban resmi admin dan perbarui status pertanyaan.
     */
    public function updateStatus(Request $request, PertanyaanUmum $pertanyaanUmum)
    {
        $validated = $request->validate([
            'status'        => ['required', 'string', 'in:diajukan,dijawab,selesai'],
            'jawaban_admin' => ['required', 'string'],
        ]);

        $pertanyaanUmum->update([
            'status'        => $validated['status'],
            'jawaban_admin' => $validated['jawaban_admin'],
        ]);

        return back()->with('success', 'Jawaban pertanyaan (' . $pertanyaanUmum->nomor_pertanyaan . ') berhasil disimpan dan dikirimkan ke masyarakat.');
    }

    /**
     * Hapus pertanyaan umum.
     */
    public function destroy(PertanyaanUmum $pertanyaanUmum)
    {
        $nomor = $pertanyaanUmum->nomor_pertanyaan;
        $pertanyaanUmum->delete();

        return redirect()->route('admin.pertanyaan-umum.index')
            ->with('success', 'Pertanyaan (' . $nomor . ') berhasil dihapus.');
    }
}
