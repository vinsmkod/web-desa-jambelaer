<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * Tampilkan formulir pengaduan masyarakat (SRS-F-011.1).
     */
    public function create()
    {
        $settings = [
            'desa_telepon' => Pengaturan::get('desa_telepon', '0813-2476-8193'),
            'desa_email'   => Pengaturan::get('desa_email', 'pemdes@jambelaer.desa.id'),
            'desa_alamat'  => Pengaturan::get('desa_alamat', 'Jl. Raya Jambelaer No. 12, Kec. Dawuan, Subang'),
        ];

        return view('pages.pengaduan', compact('settings'));
    }

    /**
     * Simpan pengaduan masyarakat ke tabel pengaduans.
     */
    public function store(Request $request)
    {
        // 1. Otorisasi: Wajib login
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'  => false,
                    'message'  => 'Silakan masuk (login) terlebih dahulu untuk mengirim pengaduan.',
                    'redirect' => route('login')
                ], 401);
            }

            session()->put('url.intended', route('pengaduan.create'));
            return redirect()->route('login')
                ->with('warning', 'Silakan masuk (login) terlebih dahulu untuk mengirim pengaduan.');
        }

        // 2. Validasi input
        $validator = Validator::make($request->all(), [
            'nama'         => ['required', 'string', 'max:255'],
            'no_whatsapp'  => ['required', 'string', 'max:25'],
            'judul'        => ['required', 'string', 'max:255'],
            'isi_pengaduan'=> ['required', 'string'],
            'lokasi'       => ['nullable', 'string', 'max:255'],
            'foto_bukti'   => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ], [
            'nama.required'          => 'Nama lengkap wajib diisi.',
            'no_whatsapp.required'   => 'Nomor WhatsApp aktif wajib diisi untuk konfirmasi.',
            'judul.required'         => 'Judul pengaduan wajib diisi.',
            'isi_pengaduan.required' => 'Uraian pengaduan wajib diisi secara jelas.',
            'foto_bukti.mimes'       => 'Foto bukti harus berupa format gambar (JPG, PNG, atau WEBP).',
            'foto_bukti.max'         => 'Ukuran foto bukti maksimal 5 MB.',
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
        $fotoBuktiPath = null;

        // 3. Upload foto bukti opsional
        if ($request->hasFile('foto_bukti') && $request->file('foto_bukti')->isValid()) {
            $fotoBuktiPath = $request->file('foto_bukti')->store('pengaduan', 'public');
        }

        // 4. Buat Pengaduan
        $nomorPengaduan = Pengaduan::generateNomorPengaduan();

        $pengaduan = Pengaduan::create([
            'nomor_pengaduan' => $nomorPengaduan,
            'user_id'         => $user->user_id,
            'nama'            => $request->nama,
            'email'           => $user->email ?? $request->input('email', '-'),
            'no_whatsapp'     => $request->no_whatsapp,
            'judul'           => $request->judul,
            'isi_pengaduan'   => $request->isi_pengaduan,
            'lokasi'          => $request->lokasi,
            'foto_bukti'      => $fotoBuktiPath,
            'status'          => 'diajukan',
        ]);

        $successMsg = 'Pengaduan Anda berhasil dikirim dengan Nomor Registrasi: ' . $pengaduan->nomor_pengaduan;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'         => true,
                'message'         => $successMsg,
                'nomor_pengaduan' => $pengaduan->nomor_pengaduan,
                'redirect'        => route('pengajuan.show.detail', ['jenis' => 'pengaduan', 'id' => $pengaduan->pengaduan_id]),
                'data'            => $pengaduan
            ]);
        }

        return redirect()->route('pengajuan.show.detail', ['jenis' => 'pengaduan', 'id' => $pengaduan->pengaduan_id])
            ->with('success', $successMsg);
    }
}
