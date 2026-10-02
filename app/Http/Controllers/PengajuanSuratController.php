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
}
