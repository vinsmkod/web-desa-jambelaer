<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSuratModel;
use App\Models\JenisSuratModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanSuratController extends Controller
{
    /**
     * Tampilkan daftar permohonan pengajuan surat (SRS-F-010).
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'semua');
        $jenisId = $request->get('jenis_id');
        $search = $request->get('q');

        $query = PengajuanSuratModel::with(['jenisSurat', 'user', 'diprosesBy', 'diverifikasiBy', 'disetujuiBy'])->latest();

        $stats = [
            'total'        => PengajuanSuratModel::count(),
            'diajukan'     => PengajuanSuratModel::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'diproses'     => PengajuanSuratModel::where('status', 'diproses')->count(),
            'diverifikasi' => PengajuanSuratModel::where('status', 'diverifikasi')->count(),
            'selesai'      => PengajuanSuratModel::whereIn('status', ['selesai', 'disetujui'])->count(),
            'ditolak'      => PengajuanSuratModel::where('status', 'ditolak')->count(),
            'dibatalkan'   => PengajuanSuratModel::where('status', 'dibatalkan')->count(),
        ];

        if ($status && $status !== 'semua') {
            if ($status === 'diajukan') {
                $query->whereIn('status', ['diajukan', 'menunggu']);
            } elseif ($status === 'selesai') {
                $query->whereIn('status', ['selesai', 'disetujui']);
            } else {
                $query->where('status', $status);
            }
        }

        if ($jenisId) {
            $query->where('jenis_surat_id', $jenisId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', "%{$search}%")
                  ->orWhere('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_kk', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }

        $pengajuan = $query->paginate(10)->withQueryString();
        $jenisSurats = JenisSuratModel::where('is_active', true)->orderBy('nama_surat')->get();

        return view('admin.pengajuan-surat.index', compact('pengajuan', 'stats', 'status', 'jenisId', 'search', 'jenisSurats'));
    }

    /**
     * Tampilkan detail pengajuan surat, berkas persyaratan, dan riwayat proses workflow.
     */
    public function show(PengajuanSuratModel $pengajuanSurat)
    {
        $pengajuanSurat->load([
            'jenisSurat',
            'user',
            'diprosesBy',
            'diverifikasiBy',
            'disetujuiBy',
            'riwayat.user'
        ]);

        return view('admin.pengajuan-surat.show', compact('pengajuanSurat'));
    }

    /**
     * Perbarui status pengajuan surat sesuai kewenangan berjenjang (SRS-F-010).
     *
     * Alur Workflow:
     * 1. Diajukan (Masyarakat)
     * 2. Diproses (Staff Desa): Memeriksa kelengkapan berkas & memproses -> 'diproses' / 'ditolak'
     * 3. Diverifikasi (Sekretaris Desa): Memverifikasi pengajuan -> 'diverifikasi' / 'ditolak'
     * 4. Selesai (Kepala Desa): Memberikan persetujuan akhir -> 'selesai' / 'ditolak'
     */
    public function updateStatus(Request $request, PengajuanSuratModel $pengajuanSurat)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'status'        => ['required', 'string', 'in:diproses,diverifikasi,selesai,ditolak,diajukan'],
            'catatan_admin' => ['nullable', 'string', 'max:2000'],
        ], [
            'status.required' => 'Status pengajuan wajib dipilih.',
            'status.in'       => 'Pilihan status tidak valid.',
        ]);

        $statusAwal = strtolower($pengajuanSurat->status ?? 'diajukan');
        $targetStatus = strtolower($validated['status']);
        $catatan = $validated['catatan_admin'] ?? null;

        // Otorisasi & Validasi Transisi Status Berdasarkan Role
        if ($user->role === UserModel::ROLE_STAFF_DESA) {
            // Staff Desa berwenang memproses berkas (diajukan -> diproses) atau menolak
            if (!in_array($targetStatus, ['diproses', 'ditolak'])) {
                abort(403, 'Kewenangan Staff Desa: Memeriksa kelengkapan berkas dan memproses pengajuan (status: Diproses) atau Menolak. Tahapan verifikasi dilakukan oleh Sekretaris Desa dan persetujuan oleh Kepala Desa.');
            }

            if ($statusAwal !== 'diajukan' && $statusAwal !== 'menunggu' && $targetStatus === 'diproses') {
                return back()->with('error', 'Pengajuan ini sudah pernah diproses sebelumnya.');
            }

            if ($targetStatus === 'diproses') {
                $pengajuanSurat->diproses_by = $user->user_id;
                $pengajuanSurat->diproses_at = now();
            }
        } elseif ($user->role === UserModel::ROLE_SEKRETARIS_DESA) {
            // Sekretaris Desa berwenang memverifikasi berkas yang sudah diproses Staff Desa
            if (!in_array($targetStatus, ['diverifikasi', 'ditolak'])) {
                abort(403, 'Kewenangan Sekretaris Desa: Melakukan verifikasi pengajuan yang telah diproses oleh Staff Desa (status: Diverifikasi) atau Menolak. Persetujuan akhir dilakukan oleh Kepala Desa.');
            }

            if ($statusAwal !== 'diproses' && $targetStatus === 'diverifikasi') {
                return back()->with('error', 'Pengajuan harus diperiksa dan diproses terlebih dahulu oleh Staff Desa sebelum dapat diverifikasi oleh Sekretaris Desa.');
            }

            if ($targetStatus === 'diverifikasi') {
                $pengajuanSurat->diverifikasi_by = $user->user_id;
                $pengajuanSurat->diverifikasi_at = now();
            }
        } elseif ($user->role === UserModel::ROLE_KEPALA_DESA) {
            // Kepala Desa berwenang memberikan persetujuan akhir (selesai) atau penolakan
            if (!in_array($targetStatus, ['selesai', 'ditolak'])) {
                abort(403, 'Kewenangan Kepala Desa: Memberikan persetujuan akhir (status: Selesai) atau penolakan.');
            }

            if ($statusAwal !== 'diverifikasi' && $targetStatus === 'selesai') {
                return back()->with('error', 'Pengajuan harus diverifikasi terlebih dahulu oleh Sekretaris Desa sebelum dapat disetujui oleh Kepala Desa.');
            }

            if ($targetStatus === 'selesai') {
                $pengajuanSurat->disetujui_by = $user->user_id;
                $pengajuanSurat->disetujui_at = now();
            }
        } elseif ($user->role === UserModel::ROLE_ADMIN) {
            // Administrator Sistem (Super-Access): Update tracking sesuai status target
            if ($targetStatus === 'diproses') {
                $pengajuanSurat->diproses_by = $user->user_id;
                $pengajuanSurat->diproses_at = now();
            } elseif ($targetStatus === 'diverifikasi') {
                $pengajuanSurat->diverifikasi_by = $user->user_id;
                $pengajuanSurat->diverifikasi_at = now();
            } elseif ($targetStatus === 'selesai') {
                $pengajuanSurat->disetujui_by = $user->user_id;
                $pengajuanSurat->disetujui_at = now();
            }
        } else {
            abort(403, 'Anda tidak memiliki hak akses untuk memproses status pengajuan surat.');
        }

        // Simpan perubahan ke tabel pengajuan_surats
        $pengajuanSurat->status = $targetStatus;
        if ($catatan !== null) {
            $pengajuanSurat->catatan_admin = $catatan;
        }
        $pengajuanSurat->save();

        // Rekam riwayat workflow ke riwayat_pengajuan_surats
        $pengajuanSurat->logRiwayat($statusAwal, $targetStatus, $user, $catatan);

        return back()->with('success', 'Status pengajuan surat (' . $pengajuanSurat->nomor_pengajuan . ') berhasil diperbarui menjadi: ' . $pengajuanSurat->status_label);
    }

    /**
     * Hapus pengajuan surat beserta berkas fisiknya.
     */
    public function destroy(PengajuanSuratModel $pengajuanSurat)
    {
        if (!Auth::user()->canManageUsers() && Auth::user()->role !== UserModel::ROLE_ADMIN) {
            abort(403, 'Hanya Staff Desa dan Kepala Desa yang berwenang menghapus arsip pengajuan.');
        }

        if ($pengajuanSurat->file_ktp) {
            Storage::disk('public')->delete($pengajuanSurat->file_ktp);
        }
        if ($pengajuanSurat->file_kk) {
            Storage::disk('public')->delete($pengajuanSurat->file_kk);
        }
        if ($pengajuanSurat->dokumen_pendukung) {
            Storage::disk('public')->delete($pengajuanSurat->dokumen_pendukung);
        }

        $nomor = $pengajuanSurat->nomor_pengajuan;
        $pengajuanSurat->delete();

        return redirect()->route('admin.pengajuan-surat.index')
            ->with('success', 'Data pengajuan surat (' . $nomor . ') berhasil dihapus.');
    }
}
