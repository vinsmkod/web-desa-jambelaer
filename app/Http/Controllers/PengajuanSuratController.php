<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PengajuanSuratController extends Controller
{
    /**
     * Tampilkan formulir pengajuan surat untuk masyarakat yang sudah login (SRS-F-010.1).
     */
    public function create(Request $request)
    {
        $jenisSurat = JenisSurat::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('nama_surat')
            ->get();

        $selectedId = $request->query('jenis_id');
        $selectedSurat = null;
        if ($selectedId) {
            $selectedSurat = $jenisSurat->firstWhere('id', $selectedId);
        }

        return view('pages.pengajuan-surat', compact('jenisSurat', 'selectedSurat'));
    }

    /**
     * Simpan pengajuan surat masyarakat ke tabel pengajuan_surats.
     */
    public function store(Request $request)
    {
        // 1. Otorisasi: Wajib login
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'  => false,
                    'message'  => 'Silakan masuk (login) terlebih dahulu untuk mengajukan permohonan surat.',
                    'redirect' => route('login')
                ], 401);
            }

            session()->put('url.intended', route('pengajuan.surat'));
            return redirect()->route('login')
                ->with('warning', 'Silakan masuk (login) terlebih dahulu untuk membuat pengajuan surat.');
        }

        // 2. Validasi Input & Berkas Persyaratan
        $validator = Validator::make($request->all(), [
            'jenis_surat_id'      => ['required', 'exists:jenis_surat,id'],
            'name'                => ['required', 'string', 'max:255'],
            'nik'                 => ['required', 'regex:/^[0-9]{16}$/'],
            'no_kk'               => ['required', 'regex:/^[0-9]{16}$/'],
            'no_whatsapp'         => ['required', 'string', 'max:25'],
            'alamat_pemohon'      => ['required', 'string', 'max:500'],
            'keperluan'           => ['required', 'string', 'max:1500'],
            'keterangan_tambahan' => ['nullable', 'string', 'max:1500'],
            'file_ktp'            => ['required', 'file', 'mimes:jpeg,jpg,png,webp,pdf', 'max:5120'],
            'file_kk'             => ['required', 'file', 'mimes:jpeg,jpg,png,webp,pdf', 'max:5120'],
            'dokumen_pendukung'   => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp,pdf', 'max:10240'],
        ], [
            'jenis_surat_id.required' => 'Pilih salah satu jenis surat yang diajukan.',
            'jenis_surat_id.exists'   => 'Jenis surat yang dipilih tidak valid.',
            'name.required'           => 'Nama pemohon wajib diisi.',
            'nik.required'            => 'Nomor Induk Kependudukan (NIK) 16 digit wajib diisi.',
            'nik.regex'               => 'NIK harus berjumlah tepat 16 digit angka numerik.',
            'no_kk.required'          => 'Nomor Kartu Keluarga (KK) 16 digit wajib diisi.',
            'no_kk.regex'             => 'Nomor Kartu Keluarga harus berjumlah tepat 16 digit angka numerik.',
            'no_whatsapp.required'    => 'Nomor WhatsApp aktif wajib diisi untuk koordinasi.',
            'alamat_pemohon.required' => 'Alamat domisili pemohon wajib diisi.',
            'keperluan.required'      => 'Tujuan / keperluan pengajuan surat wajib dijelaskan.',
            'file_ktp.required'       => 'Berkas KTP (foto/scan) wajib diunggah sebagai persyaratan.',
            'file_ktp.mimes'          => 'Berkas KTP harus berformat JPG, PNG, WEBP, atau PDF.',
            'file_ktp.max'            => 'Ukuran berkas KTP maksimal 5 MB.',
            'file_kk.required'        => 'Berkas Kartu Keluarga (KK) wajib diunggah sebagai persyaratan.',
            'file_kk.mimes'           => 'Berkas KK harus berformat JPG, PNG, WEBP, atau PDF.',
            'file_kk.max'             => 'Ukuran berkas KK maksimal 5 MB.',
            'dokumen_pendukung.mimes' => 'Dokumen pendukung harus berformat JPG, PNG, WEBP, atau PDF.',
            'dokumen_pendukung.max'   => 'Ukuran dokumen pendukung maksimal 10 MB.',
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

        $jenisSurat = JenisSurat::findOrFail($request->jenis_surat_id);
        $user = Auth::user();

        // 3. Upload Berkas Aman
        $pathKtp = $request->file('file_ktp')->store('pengajuan-surat/ktp', 'public');
        $pathKk = $request->file('file_kk')->store('pengajuan-surat/kk', 'public');
        $pathPendukung = null;
        if ($request->hasFile('dokumen_pendukung') && $request->file('dokumen_pendukung')->isValid()) {
            $pathPendukung = $request->file('dokumen_pendukung')->store('pengajuan-surat/pendukung', 'public');
        }

        // 4. Buat Pengajuan Surat
        $nomorPengajuan = PengajuanSurat::generateNomorPengajuan();

        $pengajuan = PengajuanSurat::create([
            'nomor_pengajuan'     => $nomorPengajuan,
            'user_id'             => $user->user_id,
            'jenis_surat_id'      => $jenisSurat->id,
            'nik'                 => $request->nik,
            'no_kk'               => $request->no_kk,
            'nama_pemohon'        => $request->name,
            'no_whatsapp'         => $request->no_whatsapp,
            'alamat_pemohon'      => $request->alamat_pemohon,
            'keperluan'           => $request->keperluan,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'file_ktp'            => $pathKtp,
            'file_kk'             => $pathKk,
            'dokumen_pendukung'   => $pathPendukung,
            'status'              => 'diajukan',
        ]);

        $successMsg = 'Pengajuan ' . $jenisSurat->nama_surat . ' Anda berhasil dikirim dengan Nomor Registrasi: ' . $pengajuan->nomor_pengajuan;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'         => true,
                'message'         => $successMsg,
                'nomor_pengajuan' => $pengajuan->nomor_pengajuan,
                'redirect'        => route('pengajuan.show.detail', ['jenis' => 'surat', 'id' => $pengajuan->pengajuan_surat_id]),
                'data'            => $pengajuan
            ]);
        }

        return redirect()->route('pengajuan.show.detail', ['jenis' => 'surat', 'id' => $pengajuan->pengajuan_surat_id])
            ->with('success', $successMsg);
    }

    /**
     * Tampilkan formulir edit pengajuan surat (SRS-F-010.1).
     * Hanya pemilik pengajuan yang masih berstatus "Diajukan" yang dapat mengubah data.
     */
    public function edit(int $id)
    {
        $pengajuan = PengajuanSurat::with('jenisSurat')->findOrFail($id);

        // Otorisasi ketat (cegah IDOR): hanya pemilik sendiri
        if ((int) $pengajuan->user_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengubah pengajuan ini.');
        }

        // Hanya pengajuan yang belum diproses yang dapat diubah
        if (!in_array(strtolower($pengajuan->status ?? 'diajukan'), ['diajukan', 'menunggu'])) {
            return redirect()
                ->route('pengajuan.show.detail', ['jenis' => 'surat', 'id' => $pengajuan->pengajuan_surat_id])
                ->with('warning', 'Pengajuan yang sudah diproses tidak dapat diubah lagi.');
        }

        $jenisSurat = JenisSurat::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('nama_surat')
            ->get();

        // Pastikan jenis surat yang dipakai pengajuan ini tetap tampil di daftar, meski kini non-aktif
        if ($pengajuan->jenisSurat && !$jenisSurat->contains('id', $pengajuan->jenis_surat_id)) {
            $jenisSurat->prepend($pengajuan->jenisSurat);
        }

        return view('pages.pengajuan-saya.edit-surat', compact('pengajuan', 'jenisSurat'));
    }

    /**
     * Perbarui data pengajuan surat milik sendiri yang masih dapat diubah.
     */
    public function update(Request $request, int $id)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);

        // Otorisasi ketat (cegah IDOR)
        if ((int) $pengajuan->user_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengubah pengajuan ini.');
        }

        if (!in_array(strtolower($pengajuan->status ?? 'diajukan'), ['diajukan', 'menunggu'])) {
            return redirect()
                ->route('pengajuan.show.detail', ['jenis' => 'surat', 'id' => $pengajuan->pengajuan_surat_id])
                ->with('warning', 'Pengajuan yang sudah diproses tidak dapat diubah lagi.');
        }

        $validator = Validator::make($request->all(), [
            'jenis_surat_id'      => ['required', 'exists:jenis_surat,id'],
            'name'                => ['required', 'string', 'max:255'],
            'nik'                 => ['required', 'regex:/^[0-9]{16}$/'],
            'no_kk'               => ['required', 'regex:/^[0-9]{16}$/'],
            'no_whatsapp'         => ['required', 'string', 'max:25'],
            'alamat_pemohon'      => ['required', 'string', 'max:500'],
            'keperluan'           => ['required', 'string', 'max:1500'],
            'keterangan_tambahan' => ['nullable', 'string', 'max:1500'],
            'file_ktp'            => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp,pdf', 'max:5120'],
            'file_kk'             => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp,pdf', 'max:5120'],
            'dokumen_pendukung'   => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp,pdf', 'max:10240'],
        ], [
            'jenis_surat_id.required' => 'Pilih salah satu jenis surat yang diajukan.',
            'jenis_surat_id.exists'   => 'Jenis surat yang dipilih tidak valid.',
            'name.required'           => 'Nama pemohon wajib diisi.',
            'nik.required'            => 'Nomor Induk Kependudukan (NIK) 16 digit wajib diisi.',
            'nik.regex'               => 'NIK harus berjumlah tepat 16 digit angka numerik.',
            'no_kk.required'          => 'Nomor Kartu Keluarga (KK) 16 digit wajib diisi.',
            'no_kk.regex'             => 'Nomor Kartu Keluarga harus berjumlah tepat 16 digit angka numerik.',
            'no_whatsapp.required'    => 'Nomor WhatsApp aktif wajib diisi untuk koordinasi.',
            'alamat_pemohon.required' => 'Alamat domisili pemohon wajib diisi.',
            'keperluan.required'      => 'Tujuan / keperluan pengajuan surat wajib dijelaskan.',
            'file_ktp.mimes'          => 'Berkas KTP harus berformat JPG, PNG, WEBP, atau PDF.',
            'file_ktp.max'            => 'Ukuran berkas KTP maksimal 5 MB.',
            'file_kk.mimes'           => 'Berkas KK harus berformat JPG, PNG, WEBP, atau PDF.',
            'file_kk.max'             => 'Ukuran berkas KK maksimal 5 MB.',
            'dokumen_pendukung.mimes' => 'Dokumen pendukung harus berformat JPG, PNG, WEBP, atau PDF.',
            'dokumen_pendukung.max'   => 'Ukuran dokumen pendukung maksimal 10 MB.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update data tekstual
        $pengajuan->jenis_surat_id      = $request->jenis_surat_id;
        $pengajuan->nama_pemohon        = $request->name;
        $pengajuan->nik                 = $request->nik;
        $pengajuan->no_kk               = $request->no_kk;
        $pengajuan->no_whatsapp         = $request->no_whatsapp;
        $pengajuan->alamat_pemohon      = $request->alamat_pemohon;
        $pengajuan->keperluan           = $request->keperluan;
        $pengajuan->keterangan_tambahan = $request->keterangan_tambahan;

        // Berkas hanya diganti bila ada unggahan baru; berkas lama dihapus dari storage
        if ($request->hasFile('file_ktp') && $request->file('file_ktp')->isValid()) {
            if ($pengajuan->file_ktp) {
                Storage::disk('public')->delete($pengajuan->file_ktp);
            }
            $pengajuan->file_ktp = $request->file('file_ktp')->store('pengajuan-surat/ktp', 'public');
        }

        if ($request->hasFile('file_kk') && $request->file('file_kk')->isValid()) {
            if ($pengajuan->file_kk) {
                Storage::disk('public')->delete($pengajuan->file_kk);
            }
            $pengajuan->file_kk = $request->file('file_kk')->store('pengajuan-surat/kk', 'public');
        }

        if ($request->hasFile('dokumen_pendukung') && $request->file('dokumen_pendukung')->isValid()) {
            if ($pengajuan->dokumen_pendukung) {
                Storage::disk('public')->delete($pengajuan->dokumen_pendukung);
            }
            $pengajuan->dokumen_pendukung = $request->file('dokumen_pendukung')->store('pengajuan-surat/pendukung', 'public');
        }

        $pengajuan->save();

        return redirect()
            ->route('pengajuan.show.detail', ['jenis' => 'surat', 'id' => $pengajuan->pengajuan_surat_id])
            ->with('success', 'Data pengajuan surat "' . $pengajuan->nomor_pengajuan . '" berhasil diperbarui.');
    }

    /**
     * Batalkan pengajuan surat milik sendiri (SRS-F-010.1).
     *
     * Hanya pemilik pengajuan yang masih berstatus "diajukan"/"menunggu" yang dapat
     * membatalkan. Mekanismenya adalah perubahan status menjadi "dibatalkan" — data
     * tetap tersimpan sebagai riwayat — bukan penghapusan record.
     */
    public function batal(int $id)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);

        // Otorisasi ketat (cegah IDOR): hanya pemilik sendiri
        if ((int) $pengajuan->user_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk membatalkan pengajuan ini.');
        }

        // Hanya pengajuan yang belum diproses yang dapat dibatalkan
        if (!in_array(strtolower($pengajuan->status ?? 'diajukan'), ['diajukan', 'menunggu'])) {
            return redirect()
                ->route('pengajuan.show.detail', ['jenis' => 'surat', 'id' => $pengajuan->pengajuan_surat_id])
                ->with('warning', 'Pengajuan tidak dapat dibatalkan karena sudah diproses.');
        }

        $pengajuan->status = 'dibatalkan';
        $pengajuan->save();

        return redirect()
            ->route('pengajuan.show.detail', ['jenis' => 'surat', 'id' => $pengajuan->pengajuan_surat_id])
            ->with('success', 'Pengajuan surat "' . $pengajuan->nomor_pengajuan . '" berhasil dibatalkan.');
    }
}
