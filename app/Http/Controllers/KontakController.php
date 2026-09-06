<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class KontakController extends Controller
{
    public function store(Request $request)
    {
        $jenisPesan = $request->input('jenis_pesan');

        // Validasi base (semua jenis pesan)
        $rules = [
            'jenis_pesan' => ['required', 'string', 'in:pertanyaan_umum,pengaduan,kerja_sama,pengajuan_acara,daftar_umkm'],
            'name'        => ['required', 'string', 'max:255'],
        ];

        // Validasi berdasarkan jenis pesan
        switch ($jenisPesan) {
            case 'pertanyaan_umum':
                $rules = array_merge($rules, [
                    'no_whatsapp' => ['required', 'string', 'max:20'],
                    'subject'     => ['required', 'string', 'max:255'],
                    'message'     => ['required', 'string'],
                ]);
                break;

            case 'pengaduan':
                $rules = array_merge($rules, [
                    'no_whatsapp' => ['required', 'string', 'max:20'],
                    'subject'     => ['required', 'string', 'max:255'],
                    'message'     => ['required', 'string'],
                    'foto_bukti'  => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
                ]);
                break;

            case 'kerja_sama':
                $rules = array_merge($rules, [
                    'no_whatsapp'      => ['required', 'string', 'max:20'],
                    'email'            => ['required', 'email', 'max:255'],
                    'nama_instansi'    => ['required', 'string', 'max:255'],
                    'message'          => ['required', 'string'],
                    'dokumen_lampiran' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
                ]);
                break;

            case 'pengajuan_acara':
                $rules = array_merge($rules, [
                    'no_whatsapp'      => ['required', 'string', 'max:20'],
                    'nama_acara'       => ['required', 'string', 'max:255'],
                    'tanggal_acara'    => ['required', 'date', 'after_or_equal:today'],
                    'waktu_acara'      => ['required', 'string'],
                    'lokasi_acara'     => ['required', 'string', 'max:255'],
                    'jumlah_peserta'   => ['required', 'integer', 'min:1'],
                    'deskripsi_acara'  => ['required', 'string'],
                    'dokumen_lampiran' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
                ]);
                break;

            case 'daftar_umkm':
                $rules = array_merge($rules, [
                    'no_whatsapp'          => ['required', 'string', 'max:20'],
                    'nama_umkm'            => ['required', 'string', 'max:255'],
                    'jenis_produk_umkm'    => ['required', 'string', 'max:100'],
                    'alamat_umkm_daftar'   => ['required', 'string'],
                    'deskripsi_umkm'       => ['required', 'string'],
                    'foto_produk'          => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
                    'jam_operasional_umkm' => ['nullable', 'string', 'max:255'],
                    'instagram_umkm'       => ['nullable', 'string', 'max:255'],
                    'isi_produk_umkm'      => ['nullable', 'string', 'max:255'],
                    'harga_produk_umkm'    => ['nullable', 'string', 'max:255'],
                    'ketersediaan_umkm'    => ['nullable', 'string', 'max:255'],
                    'sertifikasi_umkm'     => ['nullable', 'string', 'max:255'],
                    'sertifikat_halal'     => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
                ]);
                break;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()->all()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Fallbacks for non-nullable DB columns (email, subject, message)
        if (!isset($data['email'])) {
            $data['email'] = $request->input('email') ?? '-';
        }
        if (!isset($data['subject'])) {
            $formattedJenis = ucwords(str_replace('_', ' ', $jenisPesan));
            $data['subject'] = $formattedJenis . (isset($data['nama_acara']) ? ': ' . $data['nama_acara'] : '');
        }
        if (!isset($data['message'])) {
            if ($jenisPesan === 'daftar_umkm') {
                $data['message'] = $data['deskripsi_umkm'] ?? '-';
            } else {
                $data['message'] = $data['deskripsi_acara'] ?? $request->input('message') ?? '-';
            }
        }

        // Database compatibility fallback for pengajuan_acara
        if ($jenisPesan === 'pengajuan_acara' && isset($data['deskripsi_acara'])) {
            $data['message'] = $data['deskripsi_acara'];
            $data['subject'] = 'Pengajuan Acara: ' . $data['nama_acara'];
        }

        // Database compatibility fallback for daftar_umkm
        if ($jenisPesan === 'daftar_umkm') {
            $data['message'] = $data['deskripsi_umkm'] ?? '-';
            $data['subject'] = 'Pendaftaran UMKM: ' . ($data['nama_umkm'] ?? '-');
        }

        // Handle upload foto bukti (pengaduan only)
        if ($jenisPesan === 'pengaduan' && $request->hasFile('foto_bukti') && $request->file('foto_bukti')->isValid()) {
            $path = $request->file('foto_bukti')->store('foto-bukti', 'public');
            $data['foto_bukti'] = $path;
        }

        // Handle upload foto produk (daftar_umkm only)
        if ($jenisPesan === 'daftar_umkm' && $request->hasFile('foto_produk') && $request->file('foto_produk')->isValid()) {
            $path = $request->file('foto_produk')->store('foto-produk', 'public');
            $data['foto_produk'] = $path;
        }

        // Handle upload sertifikat halal PDF (daftar_umkm only)
        if ($jenisPesan === 'daftar_umkm' && $request->hasFile('sertifikat_halal') && $request->file('sertifikat_halal')->isValid()) {
            $path = $request->file('sertifikat_halal')->store('sertifikat-halal', 'public');
            $data['sertifikat_halal'] = $path;
        }

        // Handle upload dokumen lampiran PDF (kerja_sama, pengajuan_acara)
        if (in_array($jenisPesan, ['kerja_sama', 'pengajuan_acara']) && $request->hasFile('dokumen_lampiran') && $request->file('dokumen_lampiran')->isValid()) {
            $path = $request->file('dokumen_lampiran')->store('dokumen-lampiran', 'public');
            $data['dokumen_lampiran'] = $path;
        }

        $pesan = Pesan::create($data);

        $successMessages = [
            'pertanyaan_umum' => 'Pertanyaan Anda berhasil dikirim! Kami akan segera menghubungi Anda.',
            'pengaduan'       => 'Pengaduan Anda berhasil kami terima! Terima kasih atas masukan Anda.',
            'kerja_sama'      => 'Proposal kerja sama Anda berhasil kami terima! Tim akan menghubungi Anda segera.',
            'pengajuan_acara' => 'Pengajuan acara Anda berhasil kami terima! Kami akan segera memproses permohonan Anda.',
            'daftar_umkm'     => 'Pendaftaran UMKM Anda berhasil dikirim! Tim kami akan menghubungi Anda untuk proses verifikasi.',
        ];

        $successMessage = $successMessages[$jenisPesan] ?? 'Pesan Anda berhasil dikirim!';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'data' => $pesan
            ]);
        }

        return back()->with('success', $successMessage);
    }
}
