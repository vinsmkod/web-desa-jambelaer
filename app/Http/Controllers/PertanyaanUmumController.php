<?php

namespace App\Http\Controllers;

use App\Models\PertanyaanUmum;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PertanyaanUmumController extends Controller
{
    /**
     * Tampilkan formulir pertanyaan umum masyarakat (SRS-F-012.1).
     */
    public function create()
    {
        $settings = [
            'desa_telepon' => Pengaturan::get('desa_telepon', '0813-2476-8193'),
            'desa_email'   => Pengaturan::get('desa_email', 'pemdes@jambelaer.desa.id'),
            'desa_alamat'  => Pengaturan::get('desa_alamat', 'Jl. Raya Jambelaer No. 12, Kec. Dawuan, Subang'),
        ];

        return view('pages.pertanyaan-umum', compact('settings'));
    }

    /**
     * Simpan pertanyaan umum masyarakat ke tabel pertanyaan_umums.
     */
    public function store(Request $request)
    {
        // 1. Otorisasi: Wajib login
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'  => false,
                    'message'  => 'Silakan masuk (login) terlebih dahulu untuk mengirim pertanyaan.',
                    'redirect' => route('login')
                ], 401);
            }

            session()->put('url.intended', route('pertanyaan-umum.create'));
            return redirect()->route('login')
                ->with('warning', 'Silakan masuk (login) terlebih dahulu untuk mengirim pertanyaan.');
        }

        // 2. Validasi input (tanpa upload dokumen)
        $validator = Validator::make($request->all(), [
            'nama'        => ['required', 'string', 'max:255'],
            'no_whatsapp' => ['required', 'string', 'max:25'],
            'subjek'      => ['required', 'string', 'max:255'],
            'pertanyaan'  => ['required', 'string'],
        ], [
            'nama.required'        => 'Nama lengkap wajib diisi.',
            'no_whatsapp.required' => 'Nomor WhatsApp aktif wajib diisi untuk pemberitahuan balasan.',
            'subjek.required'      => 'Subjek / topik pertanyaan wajib diisi.',
            'pertanyaan.required'  => 'Isi pertanyaan wajib diisi secara jelas.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors()->all()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // 3. Buat Pertanyaan Umum
        $nomorPertanyaan = PertanyaanUmum::generateNomorPertanyaan();

        $pertanyaan = PertanyaanUmum::create([
            'nomor_pertanyaan' => $nomorPertanyaan,
            'user_id'          => $user->user_id,
            'nama'             => $request->nama,
            'email'            => $user->email ?? $request->input('email', '-'),
            'no_whatsapp'      => $request->no_whatsapp,
            'subjek'           => $request->subjek,
            'pertanyaan'       => $request->pertanyaan,
            'status'           => 'diajukan',
        ]);

        $successMsg = 'Pertanyaan Anda berhasil dikirim dengan Nomor Registrasi: ' . $pertanyaan->nomor_pertanyaan;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'          => true,
                'message'          => $successMsg,
                'nomor_pertanyaan' => $pertanyaan->nomor_pertanyaan,
                'redirect'         => route('pengajuan.show.detail', ['jenis' => 'pertanyaan', 'id' => $pertanyaan->pertanyaan_id]),
                'data'             => $pertanyaan
            ]);
        }

        return redirect()->route('pengajuan.show.detail', ['jenis' => 'pertanyaan', 'id' => $pertanyaan->pertanyaan_id])
            ->with('success', $successMsg);
    }

    /**
     * Tampilkan formulir edit pertanyaan umum (SRS-F-012.1).
     * Hanya pemilik pertanyaan yang belum dijawab yang dapat mengubah data.
     */
    public function edit(int $id)
    {
        $pertanyaan = PertanyaanUmum::findOrFail($id);

        // Otorisasi ketat (cegah IDOR): hanya pemilik sendiri
        if ((int) $pertanyaan->user_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengubah pertanyaan ini.');
        }

        // Hanya pertanyaan yang belum dijawab yang dapat diubah
        if (!in_array(strtolower($pertanyaan->status ?? 'diajukan'), ['diajukan', 'menunggu'])) {
            return redirect()
                ->route('pengajuan.show.detail', ['jenis' => 'pertanyaan', 'id' => $pertanyaan->pertanyaan_id])
                ->with('warning', 'Pertanyaan yang sudah dijawab tidak dapat diubah lagi.');
        }

        return view('pages.pengajuan-saya.edit-pertanyaan', compact('pertanyaan'));
    }

    /**
     * Perbarui data pertanyaan umum milik sendiri yang masih dapat diubah.
     */
    public function update(Request $request, int $id)
    {
        $pertanyaan = PertanyaanUmum::findOrFail($id);

        // Otorisasi ketat (cegah IDOR)
        if ((int) $pertanyaan->user_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengubah pertanyaan ini.');
        }

        if (!in_array(strtolower($pertanyaan->status ?? 'diajukan'), ['diajukan', 'menunggu'])) {
            return redirect()
                ->route('pengajuan.show.detail', ['jenis' => 'pertanyaan', 'id' => $pertanyaan->pertanyaan_id])
                ->with('warning', 'Pertanyaan yang sudah dijawab tidak dapat diubah lagi.');
        }

        $validator = Validator::make($request->all(), [
            'nama'        => ['required', 'string', 'max:255'],
            'no_whatsapp' => ['required', 'string', 'max:25'],
            'subjek'      => ['required', 'string', 'max:255'],
            'pertanyaan'  => ['required', 'string'],
        ], [
            'nama.required'        => 'Nama lengkap wajib diisi.',
            'no_whatsapp.required' => 'Nomor WhatsApp aktif wajib diisi untuk pemberitahuan balasan.',
            'subjek.required'      => 'Subjek / topik pertanyaan wajib diisi.',
            'pertanyaan.required'  => 'Isi pertanyaan wajib diisi secara jelas.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pertanyaan->nama        = $request->nama;
        $pertanyaan->no_whatsapp = $request->no_whatsapp;
        $pertanyaan->subjek      = $request->subjek;
        $pertanyaan->pertanyaan  = $request->pertanyaan;
        $pertanyaan->save();

        return redirect()
            ->route('pengajuan.show.detail', ['jenis' => 'pertanyaan', 'id' => $pertanyaan->pertanyaan_id])
            ->with('success', 'Data pertanyaan "' . $pertanyaan->nomor_pertanyaan . '" berhasil diperbarui.');
    }
}
