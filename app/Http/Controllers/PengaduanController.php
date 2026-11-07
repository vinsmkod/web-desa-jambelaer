<?php

namespace App\Http\Controllers;

use App\Models\PengaduanModel;
use App\Models\PengaturanModel;
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
            'desa_telepon' => PengaturanModel::get('desa_telepon', '0813-2476-8193'),
            'desa_email'   => PengaturanModel::get('desa_email', 'pemdes@jambelaer.desa.id'),
            'desa_alamat'  => PengaturanModel::get('desa_alamat', 'Jl. Raya Jambelaer No. 12, Kec. Dawuan, Subang'),
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
        $nomorPengaduan = PengaduanModel::generateNomorPengaduan();

        $pengaduan = PengaduanModel::create([
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

    /**
     * Tampilkan formulir edit pengaduan (SRS-F-011.1).
     * Hanya pemilik pengaduan yang masih berstatus "Diajukan" yang dapat mengubah data.
     */
    public function edit(int $id)
    {
        $pengaduan = PengaduanModel::findOrFail($id);

        // Otorisasi ketat (cegah IDOR): hanya pemilik sendiri
        if ((int) $pengaduan->user_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengubah pengaduan ini.');
        }

        // Hanya pengaduan yang belum diproses yang dapat diubah
        if (!in_array(strtolower($pengaduan->status ?? 'diajukan'), ['diajukan', 'menunggu'])) {
            return redirect()
                ->route('pengajuan.show.detail', ['jenis' => 'pengaduan', 'id' => $pengaduan->pengaduan_id])
                ->with('warning', 'Pengaduan yang sudah diproses tidak dapat diubah lagi.');
        }

        return view('pages.pengajuan-saya.edit-pengaduan', compact('pengaduan'));
    }

    /**
     * Perbarui data pengaduan milik sendiri yang masih dapat diubah.
     */
    public function update(Request $request, int $id)
    {
        $pengaduan = PengaduanModel::findOrFail($id);

        // Otorisasi ketat (cegah IDOR)
        if ((int) $pengaduan->user_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengubah pengaduan ini.');
        }

        if (!in_array(strtolower($pengaduan->status ?? 'diajukan'), ['diajukan', 'menunggu'])) {
            return redirect()
                ->route('pengajuan.show.detail', ['jenis' => 'pengaduan', 'id' => $pengaduan->pengaduan_id])
                ->with('warning', 'Pengaduan yang sudah diproses tidak dapat diubah lagi.');
        }

        $validator = Validator::make($request->all(), [
            'nama'          => ['required', 'string', 'max:255'],
            'no_whatsapp'   => ['required', 'string', 'max:25'],
            'judul'         => ['required', 'string', 'max:255'],
            'isi_pengaduan' => ['required', 'string'],
            'lokasi'        => ['nullable', 'string', 'max:255'],
            'foto_bukti'    => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ], [
            'nama.required'          => 'Nama lengkap wajib diisi.',
            'no_whatsapp.required'   => 'Nomor WhatsApp aktif wajib diisi untuk konfirmasi.',
            'judul.required'         => 'Judul pengaduan wajib diisi.',
            'isi_pengaduan.required' => 'Uraian pengaduan wajib diisi secara jelas.',
            'foto_bukti.mimes'       => 'Foto bukti harus berupa format gambar (JPG, PNG, atau WEBP).',
            'foto_bukti.max'         => 'Ukuran foto bukti maksimal 5 MB.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pengaduan->nama          = $request->nama;
        $pengaduan->no_whatsapp   = $request->no_whatsapp;
        $pengaduan->judul         = $request->judul;
        $pengaduan->isi_pengaduan = $request->isi_pengaduan;
        $pengaduan->lokasi        = $request->lokasi;

        // Foto bukti hanya diganti bila ada unggahan baru; foto lama dihapus dari storage
        if ($request->hasFile('foto_bukti') && $request->file('foto_bukti')->isValid()) {
            if ($pengaduan->foto_bukti) {
                Storage::disk('public')->delete($pengaduan->foto_bukti);
            }
            $pengaduan->foto_bukti = $request->file('foto_bukti')->store('pengaduan', 'public');
        }

        $pengaduan->save();

        return redirect()
            ->route('pengajuan.show.detail', ['jenis' => 'pengaduan', 'id' => $pengaduan->pengaduan_id])
            ->with('success', 'Data pengaduan "' . $pengaduan->nomor_pengaduan . '" berhasil diperbarui.');
    }

    /**
     * Batalkan pengaduan milik sendiri (SRS-F-011.1).
     *
     * Hanya pemilik pengaduan yang masih berstatus "diajukan"/"menunggu" yang dapat
     * membatalkan. Mekanismenya adalah perubahan status menjadi "dibatalkan" — data
     * tetap tersimpan sebagai riwayat — bukan penghapusan record.
     */
    public function batal(int $id)
    {
        $pengaduan = PengaduanModel::findOrFail($id);

        // Otorisasi ketat (cegah IDOR): hanya pemilik sendiri
        if ((int) $pengaduan->user_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk membatalkan pengaduan ini.');
        }

        // Hanya pengaduan yang belum diproses yang dapat dibatalkan
        if (!in_array(strtolower($pengaduan->status ?? 'diajukan'), ['diajukan', 'menunggu'])) {
            return redirect()
                ->route('pengajuan.show.detail', ['jenis' => 'pengaduan', 'id' => $pengaduan->pengaduan_id])
                ->with('warning', 'Pengaduan tidak dapat dibatalkan karena sudah diproses.');
        }

        $pengaduan->status = 'dibatalkan';
        $pengaduan->save();

        return redirect()
            ->route('pengajuan.show.detail', ['jenis' => 'pengaduan', 'id' => $pengaduan->pengaduan_id])
            ->with('success', 'Pengaduan "' . $pengaduan->nomor_pengaduan . '" berhasil dibatalkan.');
    }
}
