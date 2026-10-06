<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use App\Models\Pengaduan;
use App\Models\PertanyaanUmum;
use App\Models\PendaftaranUmkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class PengajuanSayaController extends Controller
{
    /**
     * Tampilkan seluruh riwayat pengajuan layanan milik pengguna yang sedang login dari 4 tabel database terpisah.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $tab = $request->query('status', 'semua');
        $jenisFilter = $request->query('jenis', 'semua');
        $search = $request->query('q');

        // 1. Ambil data dari masing-masing tabel
        $surats = PengajuanSurat::with('jenisSurat')->where('user_id', $userId)->get()->map(function ($item) {
            $item->jenis_layanan = 'pengajuan_surat';
            $item->jenis_layanan_label = $item->jenisSurat ? $item->jenisSurat->nama_surat : 'Pengajuan Surat';
            $item->primary_id = $item->pengajuan_surat_id;
            $item->nomor_tiket = $item->nomor_pengajuan;
            $item->judul_layanan = $item->jenisSurat ? $item->jenisSurat->nama_surat : 'Pengajuan Surat';
            $item->ringkasan = $item->keperluan;
            return $item;
        });

        $pengaduans = Pengaduan::where('user_id', $userId)->get()->map(function ($item) {
            $item->jenis_layanan = 'pengaduan';
            $item->jenis_layanan_label = 'Pengaduan Masyarakat';
            $item->primary_id = $item->pengaduan_id;
            $item->nomor_tiket = $item->nomor_pengaduan;
            $item->judul_layanan = $item->judul;
            $item->ringkasan = $item->isi_pengaduan;
            $item->catatan_admin = $item->tanggapan_admin;
            return $item;
        });

        $pertanyaans = PertanyaanUmum::where('user_id', $userId)->get()->map(function ($item) {
            $item->jenis_layanan = 'pertanyaan_umum';
            $item->jenis_layanan_label = 'Pertanyaan Umum';
            $item->primary_id = $item->pertanyaan_id;
            $item->nomor_tiket = $item->nomor_pertanyaan;
            $item->judul_layanan = $item->subjek;
            $item->ringkasan = $item->pertanyaan;
            $item->catatan_admin = $item->jawaban_admin;
            return $item;
        });

        $umkms = PendaftaranUmkm::where('user_id', $userId)->get()->map(function ($item) {
            $item->jenis_layanan = 'pendaftaran_umkm';
            $item->jenis_layanan_label = 'Pendaftaran UMKM';
            $item->primary_id = $item->pendaftaran_umkm_id;
            $item->nomor_tiket = $item->nomor_pendaftaran;
            $item->judul_layanan = 'UMKM: ' . $item->nama_usaha;
            $item->ringkasan = $item->deskripsi_usaha;
            return $item;
        });

        // 2. Gabungkan collection
        $allSubmissions = collect()
            ->merge($surats)
            ->merge($pengaduans)
            ->merge($pertanyaans)
            ->merge($umkms);

        // 2b. Helper aksi Edit per item — hanya pengajuan milik sendiri yang berstatus
        //     "diajukan"/"menunggu" yang masih boleh diubah oleh masyarakat.
        foreach ($allSubmissions as $item) {
            $item->editable = in_array(strtolower($item->status ?? ''), ['diajukan', 'menunggu']);

            $item->edit_url = match ($item->jenis_layanan) {
                'pengajuan_surat'  => route('pengajuan.surat.edit', $item->primary_id),
                'pengaduan'        => route('pengaduan.edit', $item->primary_id),
                'pertanyaan_umum'  => route('pertanyaan-umum.edit', $item->primary_id),
                'pendaftaran_umkm' => route('pendaftaran-umkm.edit', $item->primary_id),
                default            => null,
            };
        }

        // 3. Hitung statistik status milik user
        $stats = [
            'semua'        => $allSubmissions->count(),
            'diajukan'     => $allSubmissions->filter(fn($p) => in_array(strtolower($p->status ?? ''), ['diajukan', 'menunggu', '']))->count(),
            'diverifikasi' => $allSubmissions->filter(fn($p) => in_array(strtolower($p->status ?? ''), ['diverifikasi', 'dijawab']))->count(),
            'diproses'     => $allSubmissions->filter(fn($p) => strtolower($p->status ?? '') === 'diproses')->count(),
            'selesai'      => $allSubmissions->filter(fn($p) => in_array(strtolower($p->status ?? ''), ['selesai', 'disetujui']))->count(),
            'ditolak'      => $allSubmissions->filter(fn($p) => strtolower($p->status ?? '') === 'ditolak')->count(),
        ];

        // 4. Filter Koleksi Berdasarkan Status
        $filtered = $allSubmissions;

        if ($tab !== 'semua') {
            $filtered = $filtered->filter(function ($item) use ($tab) {
                $status = strtolower($item->status ?? 'diajukan');
                return match($tab) {
                    'diajukan'     => in_array($status, ['diajukan', 'menunggu']),
                    'diverifikasi' => in_array($status, ['diverifikasi', 'dijawab']),
                    'diproses'     => $status === 'diproses',
                    'selesai'      => in_array($status, ['selesai', 'disetujui']),
                    'ditolak'      => $status === 'ditolak',
                    default        => true,
                };
            });
        }

        // 5. Filter Koleksi Berdasarkan Jenis Layanan
        if ($jenisFilter !== 'semua') {
            $filtered = $filtered->filter(fn($item) => $item->jenis_layanan === $jenisFilter);
        }

        // 6. Filter Pencarian
        if ($search) {
            $filtered = $filtered->filter(function ($item) use ($search) {
                $needle = strtolower($search);
                return str_contains(strtolower($item->nomor_tiket ?? ''), $needle)
                    || str_contains(strtolower($item->judul_layanan ?? ''), $needle)
                    || str_contains(strtolower($item->ringkasan ?? ''), $needle)
                    || str_contains(strtolower($item->jenis_layanan_label ?? ''), $needle);
            });
        }

        // 7. Sort Descending by created_at
        $sorted = $filtered->sortByDesc(fn($item) => $item->created_at)->values();

        // 8. Manual Pagination
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $paginatedItems = $sorted->slice(($page - 1) * $perPage, $perPage)->all();

        $pengajuanList = new LengthAwarePaginator(
            $paginatedItems,
            $sorted->count(),
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('pages.pengajuan-saya.index', compact('pengajuanList', 'stats', 'tab', 'jenisFilter', 'search'));
    }

    /**
     * Tampilkan detail pelacakan pengajuan spesifik dari modul masing-masing.
     */
    public function showDetail(string $jenis, int $id)
    {
        $userId = Auth::id();
        $isAdmin = Auth::user() && Auth::user()->isAdmin();

        $data = null;
        $jenisLayanan = '';

        switch ($jenis) {
            case 'surat':
            case 'pengajuan_surat':
                $data = PengajuanSurat::with('jenisSurat')->findOrFail($id);
                $jenisLayanan = 'pengajuan_surat';
                break;

            case 'pengaduan':
                $data = Pengaduan::findOrFail($id);
                $jenisLayanan = 'pengaduan';
                break;

            case 'pertanyaan':
            case 'pertanyaan_umum':
                $data = PertanyaanUmum::findOrFail($id);
                $jenisLayanan = 'pertanyaan_umum';
                break;

            case 'umkm':
            case 'pendaftaran_umkm':
                $data = PendaftaranUmkm::with('produkDipublikasikan')->findOrFail($id);
                $jenisLayanan = 'pendaftaran_umkm';
                break;

            default:
                abort(404, 'Jenis layanan tidak ditemukan.');
        }

        // Pemeriksaan Otorisasi Ketat (Mencegah IDOR):
        if ($data->user_id !== $userId && !$isAdmin) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat rincian pengajuan ini.');
        }

        return view('pages.pengajuan-saya.show', compact('data', 'jenisLayanan'));
    }

    /**
     * Fallback backward compatibility untuk rute lama /pengajuan-saya/{id}.
     */
    public function show($id)
    {
        return redirect()->route('pengajuan.saya');
    }
}
