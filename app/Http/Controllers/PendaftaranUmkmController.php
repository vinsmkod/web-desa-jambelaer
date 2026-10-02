<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranUmkm;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PendaftaranUmkmController extends Controller
{
    /**
     * Tampilkan formulir pendaftaran UMKM untuk dipromosikan (SRS-F-013.1).
     */
    public function create()
    {
        $settings = [
            'desa_telepon' => Pengaturan::get('desa_telepon', '0813-2476-8193'),
            'desa_email'   => Pengaturan::get('desa_email', 'pemdes@jambelaer.desa.id'),
        ];

        return view('pages.pendaftaran-umkm', compact('settings'));
    }

    /**
     * Simpan pendaftaran UMKM ke tabel pendaftaran_umkms.
     */
    public function store(Request $request)
    {
        // 1. Otorisasi: Wajib login
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'  => false,
                    'message'  => 'Silakan masuk (login) terlebih dahulu untuk mendaftarkan UMKM.',
                    'redirect' => route('login')
                ], 401);
            }

            session()->put('url.intended', route('pendaftaran-umkm.create'));
            return redirect()->route('login')
                ->with('warning', 'Silakan masuk (login) terlebih dahulu untuk mendaftarkan usaha UMKM Anda.');
        }

        // 2. Validasi input
        $validator = Validator::make($request->all(), [
            'nama_usaha'        => ['required', 'string', 'max:255'],
            'nama_pemilik'      => ['required', 'string', 'max:255'],
            'alamat_usaha'      => ['required', 'string', 'max:500'],
            'deskripsi_usaha'   => ['required', 'string'],
            'produk'            => ['required', 'string', 'max:255'],
            'nomor_whatsapp'    => ['required', 'string', 'max:25'],
            'instagram'         => ['nullable', 'string', 'max:255'],
            'nib'               => ['nullable'], // bisa file atau teks nomor NIB
            'sertifikasi_halal' => ['nullable'], // bisa file atau teks nomor sertifikat
            'foto_produk'       => ['required', 'file', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ], [
            'nama_usaha.required'      => 'Nama usaha / UMKM wajib diisi.',
            'nama_pemilik.required'    => 'Nama pemilik usaha wajib diisi.',
            'alamat_usaha.required'    => 'Alamat lokasi usaha wajib diisi.',
            'deskripsi_usaha.required' => 'Deskripsi profil usaha wajib dijelaskan.',
            'produk.required'          => 'Kategori atau nama produk unggulan wajib diisi.',
            'nomor_whatsapp.required'  => 'Nomor WhatsApp aktif pemesanan/kontak wajib diisi.',
            'foto_produk.required'     => 'Foto produk wajib diunggah sebagai materi promosi.',
            'foto_produk.mimes'        => 'Foto produk harus berformat JPG, PNG, atau WEBP.',
            'foto_produk.max'          => 'Ukuran foto produk maksimal 5 MB.',
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

        // 3. Handle upload berkas (foto produk, NIB file, Sertifikasi Halal file)
        $pathFotoProduk = $request->file('foto_produk')->store('pendaftaran-umkm/produk', 'public');

        $nibValue = $request->input('nib');
        if ($request->hasFile('nib') && $request->file('nib')->isValid()) {
            $nibValue = $request->file('nib')->store('pendaftaran-umkm/nib', 'public');
        }

        $halalValue = $request->input('sertifikasi_halal');
        if ($request->hasFile('sertifikasi_halal') && $request->file('sertifikasi_halal')->isValid()) {
            $halalValue = $request->file('sertifikasi_halal')->store('pendaftaran-umkm/halal', 'public');
        }

        // 4. Buat Pendaftaran UMKM
        $nomorPendaftaran = PendaftaranUmkm::generateNomorPendaftaran();

        $umkm = PendaftaranUmkm::create([
            'nomor_pendaftaran' => $nomorPendaftaran,
            'user_id'           => $user->user_id,
            'nama_usaha'        => $request->nama_usaha,
            'nama_pemilik'      => $request->nama_pemilik,
            'alamat_usaha'      => $request->alamat_usaha,
            'deskripsi_usaha'   => $request->deskripsi_usaha,
            'produk'            => $request->produk,
            'nomor_whatsapp'    => $request->nomor_whatsapp,
            'instagram'         => $request->instagram,
            'nib'               => $nibValue,
            'sertifikasi_halal' => $halalValue,
            'foto_produk'       => $pathFotoProduk,
            'status'            => 'diajukan',
        ]);

        $successMsg = 'Pendaftaran UMKM ' . $umkm->nama_usaha . ' berhasil dikirim dengan Nomor Registrasi: ' . $umkm->nomor_pendaftaran;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'           => true,
                'message'           => $successMsg,
                'nomor_pendaftaran' => $umkm->nomor_pendaftaran,
                'redirect'          => route('pengajuan.show.detail', ['jenis' => 'umkm', 'id' => $umkm->pendaftaran_umkm_id]),
                'data'              => $umkm
            ]);
        }

        return redirect()->route('pengajuan.show.detail', ['jenis' => 'umkm', 'id' => $umkm->pendaftaran_umkm_id])
            ->with('success', $successMsg);
    }
}
