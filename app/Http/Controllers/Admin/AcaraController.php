<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcaraModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AcaraController extends Controller
{
    /**
     * Tampilkan daftar agenda acara desa (Informasi Publik)
     */
    public function index(Request $request)
    {
        AcaraModel::cleanupExpiredAcara();

        $tab = $request->query('tab', 'semua');
        $search = $request->query('q');

        $query = AcaraModel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_acara', 'like', "%{$search}%")
                  ->orWhere('lokasi_acara', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('nama_instansi', 'like', "%{$search}%");
            });
        }

        // Filter tab
        switch ($tab) {
            case 'publik':
                $query->where('dipublikasikan', true)
                      ->where(function ($q) {
                          $q->whereNull('is_archived')->orWhere('is_archived', false);
                      });
                break;

            case 'draf':
                $query->where('dipublikasikan', false)
                      ->where(function ($q) {
                          $q->whereNull('is_archived')->orWhere('is_archived', false);
                      });
                break;

            case 'arsip':
                $query->where('is_archived', true);
                break;

            case 'semua':
            default:
                $query->where(function ($q) {
                    $q->whereNull('is_archived')->orWhere('is_archived', false);
                });
                break;
        }

        $acaras = $query->orderBy('tanggal_acara', 'asc')
                        ->orderBy('waktu_acara', 'asc')
                        ->paginate(10)
                        ->withQueryString();

        // Hitung statistik untuk cards & tabs
        $activeQuery = AcaraModel::where(function ($q) {
            $q->whereNull('is_archived')->orWhere('is_archived', false);
        });

        $stats = [
            'total'  => (clone $activeQuery)->count(),
            'publik' => (clone $activeQuery)->where('dipublikasikan', true)->count(),
            'draf'   => (clone $activeQuery)->where('dipublikasikan', false)->count(),
            'arsip'  => AcaraModel::where('is_archived', true)->count(),
        ];

        return view('admin.acara.index', compact('acaras', 'stats', 'tab', 'search'));
    }

    /**
     * Form tambah agenda acara desa baru
     */
    public function create()
    {
        return view('admin.acara.create');
    }

    /**
     * Simpan agenda acara desa baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_acara'       => ['required', 'string', 'max:150'],
            'tanggal_acara'    => ['required', 'date'],
            'waktu_acara'      => ['nullable'],
            'lokasi_acara'     => ['required', 'string', 'max:255'],
            'name'             => ['required', 'string', 'max:100'],
            'nama_instansi'    => ['nullable', 'string', 'max:100'],
            'no_whatsapp'      => ['nullable', 'string', 'max:25'],
            'jumlah_peserta'   => ['nullable', 'integer', 'min:0'],
            'deskripsi_acara'  => ['required', 'string'],
            'foto_bukti'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'dokumen_lampiran' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'dipublikasikan'   => ['nullable'],
            'catatan_admin'    => ['nullable', 'string'],
        ], [
            'nama_acara.required'      => 'Nama acara wajib diisi.',
            'tanggal_acara.required'   => 'Tanggal acara wajib diisi.',
            'lokasi_acara.required'    => 'Lokasi acara wajib diisi.',
            'name.required'            => 'Nama penyelenggara/panitia wajib diisi.',
            'deskripsi_acara.required' => 'Deskripsi acara wajib diisi.',
            'foto_bukti.image'         => 'Poster/Foto acara harus berupa gambar.',
            'dokumen_lampiran.mimes'   => 'Dokumen lampiran harus berformat PDF.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $dir = public_path('uploads/acara');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $filename = 'acara_' . time() . '_' . Str::slug(substr($request->nama_acara, 0, 30)) . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $fotoPath = '/uploads/acara/' . $filename;
        }

        $dokumenPath = null;
        if ($request->hasFile('dokumen_lampiran')) {
            $dokumenPath = $request->file('dokumen_lampiran')->store('agenda-acara', 'public');
        }

        $dipublikasikan = ($request->has('dipublikasikan') || $request->dipublikasikan == '1');

        $acara = AcaraModel::create([
            'user_id'          => Auth::id(),
            'nama_acara'       => $request->nama_acara,
            'tanggal_acara'    => $request->tanggal_acara,
            'waktu_acara'      => $request->waktu_acara,
            'lokasi_acara'     => $request->lokasi_acara,
            'name'             => $request->name,
            'nama_instansi'    => $request->nama_instansi,
            'no_whatsapp'      => $request->no_whatsapp,
            'jumlah_peserta'   => $request->jumlah_peserta ?: 0,
            'deskripsi_acara'  => $request->deskripsi_acara,
            'foto_bukti'       => $fotoPath,
            'dokumen_lampiran' => $dokumenPath,
            'status'           => 'disetujui',
            'dipublikasikan'   => $dipublikasikan,
            'is_read'          => true,
            'is_archived'      => false,
            'catatan_admin'    => $request->catatan_admin,
        ]);

        return redirect()->route('admin.acara.index')
            ->with('success', 'Agenda Acara "' . $acara->nama_acara . '" berhasil ditambahkan ' . ($dipublikasikan ? 'dan langsung dipublikasikan ke website!' : 'sebagai draf.'));
    }

    /**
     * Tampilkan detail agenda acara
     */
    public function show(AcaraModel $acara)
    {
        $acara->update(['is_read' => true]);
        return view('admin.acara.show', ['acara' => $acara, 'pesan' => $acara]);
    }

    /**
     * Form edit agenda acara
     */
    public function edit(AcaraModel $acara)
    {
        return view('admin.acara.edit', ['acara' => $acara, 'pesan' => $acara]);
    }

    /**
     * Perbarui data agenda acara
     */
    public function update(Request $request, AcaraModel $acara)
    {
        $request->validate([
            'nama_acara'       => ['required', 'string', 'max:150'],
            'tanggal_acara'    => ['required', 'date'],
            'waktu_acara'      => ['nullable'],
            'lokasi_acara'     => ['required', 'string', 'max:255'],
            'name'             => ['required', 'string', 'max:100'],
            'nama_instansi'    => ['nullable', 'string', 'max:100'],
            'no_whatsapp'      => ['nullable', 'string', 'max:25'],
            'jumlah_peserta'   => ['nullable', 'integer', 'min:0'],
            'deskripsi_acara'  => ['required', 'string'],
            'foto_bukti'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'dokumen_lampiran' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'dipublikasikan'   => ['nullable'],
            'catatan_admin'    => ['nullable', 'string'],
        ], [
            'nama_acara.required'      => 'Nama acara wajib diisi.',
            'tanggal_acara.required'   => 'Tanggal acara wajib diisi.',
            'lokasi_acara.required'    => 'Lokasi acara wajib diisi.',
            'name.required'            => 'Nama penyelenggara wajib diisi.',
            'deskripsi_acara.required' => 'Deskripsi acara wajib diisi.',
            'foto_bukti.image'         => 'Poster/Foto acara harus berupa gambar.',
            'dokumen_lampiran.mimes'   => 'Dokumen lampiran harus berformat PDF.',
        ]);

        $fotoPath = $acara->foto_bukti;
        if ($request->hasFile('foto_bukti')) {
            if ($fotoPath) {
                if (file_exists(public_path($fotoPath))) {
                    @unlink(public_path($fotoPath));
                } elseif (Storage::disk('public')->exists($fotoPath)) {
                    Storage::disk('public')->delete($fotoPath);
                }
            }

            $file = $request->file('foto_bukti');
            $dir = public_path('uploads/acara');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $filename = 'acara_' . time() . '_' . Str::slug(substr($request->nama_acara, 0, 30)) . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $fotoPath = '/uploads/acara/' . $filename;
        }

        $dokumenPath = $acara->dokumen_lampiran;
        if ($request->hasFile('dokumen_lampiran')) {
            if ($dokumenPath) {
                Storage::disk('public')->delete($dokumenPath);
            }
            $dokumenPath = $request->file('dokumen_lampiran')->store('agenda-acara', 'public');
        }

        $dipublikasikan = ($request->has('dipublikasikan') || $request->dipublikasikan == '1');

        $acara->update([
            'name'             => $request->name,
            'nama_acara'       => $request->nama_acara,
            'tanggal_acara'    => $request->tanggal_acara,
            'waktu_acara'      => $request->waktu_acara,
            'lokasi_acara'     => $request->lokasi_acara,
            'jumlah_peserta'   => $request->jumlah_peserta ?: 0,
            'deskripsi_acara'  => $request->deskripsi_acara,
            'nama_instansi'    => $request->nama_instansi,
            'no_whatsapp'      => $request->no_whatsapp,
            'foto_bukti'       => $fotoPath,
            'dokumen_lampiran' => $dokumenPath,
            'dipublikasikan'   => $dipublikasikan,
            'catatan_admin'    => $request->catatan_admin,
        ]);

        return redirect()->route('admin.acara.show', $acara)
            ->with('success', 'Data agenda acara "' . $acara->nama_acara . '" berhasil diperbarui!');
    }

    /**
     * Hapus agenda acara
     */
    public function destroy(AcaraModel $acara)
    {
        if ($acara->foto_bukti) {
            if (file_exists(public_path($acara->foto_bukti))) {
                @unlink(public_path($acara->foto_bukti));
            } elseif (Storage::disk('public')->exists($acara->foto_bukti)) {
                Storage::disk('public')->delete($acara->foto_bukti);
            }
        }

        if ($acara->dokumen_lampiran) {
            Storage::disk('public')->delete($acara->dokumen_lampiran);
        }

        $nama = $acara->nama_acara;
        $acara->delete();

        return redirect()->route('admin.acara.index')
            ->with('success', 'Agenda Acara "' . $nama . '" berhasil dihapus.');
    }

    /**
     * Toggle status publikasi agenda acara ke website desa
     */
    public function publikasiAcara(AcaraModel $acara, Request $request)
    {
        $newStatus = !$acara->dipublikasikan;
        $acara->update(['dipublikasikan' => $newStatus]);

        $msg = $newStatus ? 'Agenda acara berhasil dipublikasikan ke website publik.' : 'Agenda acara ditarik dari publikasi website.';
        return back()->with('success', $msg);
    }

    /**
     * Update status agenda acara (disetujui, menunggu, ditolak)
     */
    public function updateStatus(Request $request, AcaraModel $acara)
    {
        $request->validate([
            'status'        => ['required', 'string', 'in:disetujui,menunggu,ditolak'],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        $acara->update([
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Status acara berhasil diperbarui.');
    }
}
