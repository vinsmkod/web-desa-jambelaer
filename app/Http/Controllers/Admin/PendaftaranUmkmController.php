<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranUmkmModel;
use App\Models\UMKMModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PendaftaranUmkmController extends Controller
{
    /**
     * Tampilkan daftar pendaftaran UMKM dari masyarakat (SRS-F-013).
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'semua');
        $search = $request->get('q');

        $query = PendaftaranUmkmModel::with(['user', 'produkDipublikasikan'])->latest();

        $stats = [
            'total'        => PendaftaranUmkmModel::count(),
            'diajukan'     => PendaftaranUmkmModel::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'diverifikasi' => PendaftaranUmkmModel::where('status', 'diverifikasi')->count(),
            'diproses'     => PendaftaranUmkmModel::where('status', 'diproses')->count(),
            'disetujui'    => PendaftaranUmkmModel::whereIn('status', ['disetujui', 'selesai'])->count(),
            'ditolak'      => PendaftaranUmkmModel::where('status', 'ditolak')->count(),
        ];

        if ($status && $status !== 'semua') {
            if ($status === 'diajukan') {
                $query->whereIn('status', ['diajukan', 'menunggu']);
            } elseif ($status === 'disetujui') {
                $query->whereIn('status', ['disetujui', 'selesai']);
            } else {
                $query->where('status', $status);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pendaftaran', 'like', "%{$search}%")
                  ->orWhere('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('nama_pemilik', 'like', "%{$search}%")
                  ->orWhere('produk', 'like', "%{$search}%")
                  ->orWhere('alamat_usaha', 'like', "%{$search}%");
            });
        }

        $umkms = $query->paginate(10)->withQueryString();
        $pendaftaranUmkms = $umkms;

        return view('admin.pendaftaran-umkm.index', compact('umkms', 'pendaftaranUmkms', 'stats', 'status', 'search'));
    }

    /**
     * Tampilkan detail pendaftaran UMKM dan pemeriksaan dokumen.
     */
    public function show(PendaftaranUmkmModel $pendaftaranUmkm)
    {
        $pendaftaranUmkm->load(['user', 'produkDipublikasikan']);
        return view('admin.pendaftaran-umkm.show', compact('pendaftaranUmkm'));
    }

    /**
     * Perbarui status verifikasi pendaftaran UMKM.
     */
    public function updateStatus(Request $request, PendaftaranUmkmModel $pendaftaranUmkm)
    {
        $validated = $request->validate([
            'status'        => ['required', 'string', 'in:diajukan,diverifikasi,diproses,disetujui,ditolak'],
            'catatan_admin' => ['nullable', 'string', 'max:2000'],
        ]);

        $pendaftaranUmkm->update([
            'status'        => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? $pendaftaranUmkm->catatan_admin,
        ]);

        return back()->with('success', 'Status pendaftaran UMKM (' . $pendaftaranUmkm->nomor_pendaftaran . ') berhasil diperbarui.');
    }

    /**
     * Publikasikan UMKM yang telah disetujui langsung ke Katalog Produk Desa (SRS-F-005).
     */
    public function publikasikan(Request $request, PendaftaranUmkmModel $pendaftaranUmkm)
    {
        // Pastikan status pendaftaran sudah disetujui atau setujui secara langsung
        $pendaftaranUmkm->update([
            'status' => 'disetujui',
            'catatan_admin' => $request->input('catatan_admin') ?? 'Pendaftaran UMKM disetujui dan telah dipublikasikan ke website desa.'
        ]);

        // Cek apakah sudah pernah dipublikasikan
        $existingProduk = UMKMModel::where('pendaftaran_umkm_id', $pendaftaranUmkm->pendaftaran_umkm_id)->first();

        if ($existingProduk) {
            $existingProduk->update(['is_active' => true]);
            return redirect()->route('admin.pendaftaran-umkm.show', $pendaftaranUmkm)
                ->with('success', 'Produk UMKM sudah terpublikasi di katalog produk desa!');
        }

        // Generate unique slug
        $baseTitle = $pendaftaranUmkm->nama_usaha;
        $slug = Str::slug($baseTitle);
        $originalSlug = $slug;
        $counter = 1;
        while (UMKMModel::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        // Gambar produk: gunakan foto produk pemohon
        $imgPath = $pendaftaranUmkm->foto_produk ?: 'uploads/img/DESA_JAMBELAER.png';

        $produk = UMKMModel::create([
            'pendaftaran_umkm_id' => $pendaftaranUmkm->pendaftaran_umkm_id,
            'created_by'          => Auth::id(),
            'slug'                => $slug,
            'title'               => $pendaftaranUmkm->nama_usaha,
            'producer'            => $pendaftaranUmkm->nama_pemilik,
            'nama_pemilik'        => $pendaftaranUmkm->nama_pemilik,
            'alamat_umkm'         => $pendaftaranUmkm->alamat_usaha,
            'no_whatsapp_umkm'    => $pendaftaranUmkm->nomor_whatsapp,
            'instagram_umkm'      => $pendaftaranUmkm->instagram,
            'price'               => 'Hubungi Penjual',
            'badge'               => 'UMKM Desa',
            'category'            => ['UMKM', $pendaftaranUmkm->produk],
            'img'                 => $imgPath,
            'desc_short'          => Str::limit(strip_tags($pendaftaranUmkm->deskripsi_usaha), 150),
            'desc_long'           => $pendaftaranUmkm->deskripsi_usaha,
            'details'             => [
                'Produk'        => $pendaftaranUmkm->produk,
                'Legalitas NIB' => $pendaftaranUmkm->nib ? 'Tersedia' : 'Belum Ada',
                'Sertifikasi'   => $pendaftaranUmkm->sertifikasi_halal ? 'Halal' : 'Dalam Proses',
            ],
            'is_active'           => true,
            'urutan'              => 0,
            'jenis'               => Str::slug($pendaftaranUmkm->produk),
            'jenis_label'         => $pendaftaranUmkm->produk,
        ]);

        return redirect()->route('admin.pendaftaran-umkm.show', $pendaftaranUmkm)
            ->with('success', 'UMKM "' . $pendaftaranUmkm->nama_usaha . '" berhasil disetujui dan dipublikasikan ke katalog produk website desa!');
    }

    /**
     * Hapus pendaftaran UMKM.
     */
    public function destroy(PendaftaranUmkmModel $pendaftaranUmkm)
    {
        if ($pendaftaranUmkm->foto_produk && Storage::disk('public')->exists($pendaftaranUmkm->foto_produk)) {
            Storage::disk('public')->delete($pendaftaranUmkm->foto_produk);
        }

        $nomor = $pendaftaranUmkm->nomor_pendaftaran;
        $pendaftaranUmkm->delete();

        return redirect()->route('admin.pendaftaran-umkm.index')
            ->with('success', 'Data pendaftaran UMKM (' . $nomor . ') berhasil dihapus.');
    }
}
