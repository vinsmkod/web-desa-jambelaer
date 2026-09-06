<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AcaraController extends Controller
{
    /**
     * Tampilkan daftar acara (dari desa & pengajuan masyarakat)
     */
    public function index(Request $request)
    {
        Pesan::cleanupExpiredAcara();

        $tab = $request->query('tab', 'semua');
        $search = $request->query('q');

        $query = Pesan::where('jenis_pesan', 'pengajuan_acara');

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
            case 'desa':
                $query->where(function ($q) {
                    $q->whereNotNull('user_id')
                      ->orWhere('name', 'like', '%desa%')
                      ->orWhere('nama_instansi', 'like', '%desa%');
                })->where(function ($q) {
                    $q->whereNull('is_archived')->orWhere('is_archived', false);
                });
                break;

            case 'pengajuan':
                $query->whereNull('user_id')
                      ->where('name', 'not like', '%desa%')
                      ->where(function ($q) {
                          $q->whereNull('nama_instansi')->orWhere('nama_instansi', 'not like', '%desa%');
                      })
                      ->where(function ($q) {
                          $q->whereNull('is_archived')->orWhere('is_archived', false);
                      });
                break;

            case 'menunggu':
                $query->where('status', 'menunggu')
                      ->where(function ($q) {
                          $q->whereNull('is_archived')->orWhere('is_archived', false);
                      });
                break;

            case 'publik':
                $query->where('status', 'disetujui')
                      ->where('dipublikasikan', true)
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
        $allActive = Pesan::where('jenis_pesan', 'pengajuan_acara')
            ->where(function ($q) {
                $q->whereNull('is_archived')->orWhere('is_archived', false);
            })->get();

        $stats = [
            'total'          => $allActive->count(),
            'desa'           => $allActive->filter(fn ($p) => $p->user_id !== null || str_contains(strtolower($p->name), 'desa') || str_contains(strtolower($p->nama_instansi ?? ''), 'desa'))->count(),
            'pengajuan'      => $allActive->filter(fn ($p) => $p->user_id === null && !str_contains(strtolower($p->name), 'desa') && !str_contains(strtolower($p->nama_instansi ?? ''), 'desa'))->count(),
            'menunggu'       => $allActive->where('status', 'menunggu')->count(),
            'disetujui'      => $allActive->where('status', 'disetujui')->count(),
            'dipublikasikan' => $allActive->where('dipublikasikan', true)->count(),
            'arsip'          => Pesan::where('jenis_pesan', 'pengajuan_acara')->where('is_archived', true)->count(),
        ];

        return view('admin.acara.index', compact('acaras', 'stats', 'tab', 'search'));
    }

    /**
     * Form tambah acara desa baru
     */
    public function create()
    {
        return view('admin.acara.create');
    }

    /**
     * Simpan acara desa baru ke database
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
            'status'           => ['nullable', 'in:menunggu,disetujui,ditolak'],
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
            $dokumenPath = $request->file('dokumen_lampiran')->store('pengajuan-acara', 'public');
        }

        $status = $request->status ?? 'disetujui';
        $dipublikasikan = ($request->has('dipublikasikan') || $request->dipublikasikan == '1') && $status === 'disetujui';

        $pesan = Pesan::create([
            'user_id'          => Auth::id(),
            'name'             => $request->name,
            'email'            => Auth::user()->email ?? 'info@jambelaer-subang.desa.id',
            'subject'          => 'Acara: ' . $request->nama_acara,
            'message'          => $request->deskripsi_acara,
            'nama_acara'       => $request->nama_acara,
            'tanggal_acara'    => $request->tanggal_acara,
            'waktu_acara'      => $request->waktu_acara,
            'lokasi_acara'     => $request->lokasi_acara,
            'jumlah_peserta'   => $request->jumlah_peserta,
            'deskripsi_acara'  => $request->deskripsi_acara,
            'nama_instansi'    => $request->nama_instansi,
            'no_whatsapp'      => $request->no_whatsapp,
            'foto_bukti'       => $fotoPath,
            'dokumen_lampiran' => $dokumenPath,
            'jenis_pesan'      => 'pengajuan_acara',
            'status'           => $status,
            'dipublikasikan'   => $dipublikasikan,
            'is_read'          => true,
            'is_archived'      => false,
            'catatan_admin'    => $request->catatan_admin,
        ]);

        return redirect()->route('admin.acara.index')
            ->with('success', 'Acara "' . $pesan->nama_acara . '" berhasil ditambahkan ' . ($dipublikasikan ? 'dan langsung dipublikasikan ke website!' : 'sebagai draf.'));
    }

    /**
     * Tampilkan detail acara
     */
    public function show(Pesan $pesan)
    {
        if ($pesan->jenis_pesan !== 'pengajuan_acara') {
            abort(404);
        }

        $pesan->update(['is_read' => true]);
        return view('admin.acara.show', compact('pesan'));
    }

    /**
     * Form edit acara
     */
    public function edit(Pesan $pesan)
    {
        if ($pesan->jenis_pesan !== 'pengajuan_acara') {
            abort(404);
        }

        return view('admin.acara.edit', compact('pesan'));
    }

    /**
     * Perbarui data acara
     */
    public function update(Request $request, Pesan $pesan)
    {
        if ($pesan->jenis_pesan !== 'pengajuan_acara') {
            abort(404);
        }

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
            'status'           => ['required', 'in:menunggu,disetujui,ditolak'],
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

        $fotoPath = $pesan->foto_bukti;
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

        $dokumenPath = $pesan->dokumen_lampiran;
        if ($request->hasFile('dokumen_lampiran')) {
            if ($dokumenPath) {
                Storage::disk('public')->delete($dokumenPath);
            }
            $dokumenPath = $request->file('dokumen_lampiran')->store('pengajuan-acara', 'public');
        }

        $status = $request->status;
        $dipublikasikan = ($status === 'disetujui') ? ($request->has('dipublikasikan') || $request->dipublikasikan == '1') : false;

        $pesan->update([
            'name'             => $request->name,
            'nama_acara'       => $request->nama_acara,
            'tanggal_acara'    => $request->tanggal_acara,
            'waktu_acara'      => $request->waktu_acara,
            'lokasi_acara'     => $request->lokasi_acara,
            'jumlah_peserta'   => $request->jumlah_peserta,
            'deskripsi_acara'  => $request->deskripsi_acara,
            'message'          => $request->deskripsi_acara,
            'nama_instansi'    => $request->nama_instansi,
            'no_whatsapp'      => $request->no_whatsapp,
            'foto_bukti'       => $fotoPath,
            'dokumen_lampiran' => $dokumenPath,
            'status'           => $status,
            'dipublikasikan'   => $dipublikasikan,
            'catatan_admin'    => $request->catatan_admin,
        ]);

        return redirect()->route('admin.acara.show', $pesan)
            ->with('success', 'Data acara "' . $pesan->nama_acara . '" berhasil diperbarui!');
    }

    /**
     * Hapus acara
     */
    public function destroy(Pesan $pesan)
    {
        if ($pesan->jenis_pesan !== 'pengajuan_acara') {
            abort(404);
        }

        if ($pesan->foto_bukti) {
            if (file_exists(public_path($pesan->foto_bukti))) {
                @unlink(public_path($pesan->foto_bukti));
            } elseif (Storage::disk('public')->exists($pesan->foto_bukti)) {
                Storage::disk('public')->delete($pesan->foto_bukti);
            }
        }

        if ($pesan->dokumen_lampiran) {
            Storage::disk('public')->delete($pesan->dokumen_lampiran);
        }

        $nama = $pesan->nama_acara;
        $pesan->delete();

        return redirect()->route('admin.acara.index')
            ->with('success', 'Acara "' . $nama . '" berhasil dihapus.');
    }

    /**
     * Ubah status verifikasi (menunggu, disetujui, ditolak)
     */
    public function updateStatus(Pesan $pesan, Request $request)
    {
        if ($pesan->jenis_pesan !== 'pengajuan_acara') {
            abort(404);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:menunggu,disetujui,ditolak'],
        ]);

        $pesan->update(['status' => $validated['status']]);

        if ($validated['status'] !== 'disetujui') {
            $pesan->update(['dipublikasikan' => false]);
        }

        $statusLabel = [
            'menunggu'  => 'Menunggu Review',
            'disetujui' => 'Disetujui',
            'ditolak'   => 'Ditolak',
        ];

        return back()->with('success', 'Status acara berhasil diubah menjadi ' . $statusLabel[$validated['status']] . '.');
    }

    /**
     * Toggle status publikasi acara ke website desa
     */
    public function publikasiAcara(Pesan $pesan, Request $request)
    {
        if ($pesan->jenis_pesan !== 'pengajuan_acara' || $pesan->status !== 'disetujui') {
            return back()->with('error', 'Hanya acara yang disetujui yang dapat dipublikasikan ke publik.');
        }

        $newStatus = !$pesan->dipublikasikan;
        $pesan->update(['dipublikasikan' => $newStatus]);

        $msg = $newStatus ? 'Acara berhasil dipublikasikan ke website publik.' : 'Acara ditarik dari publikasi website.';
        return back()->with('success', $msg);
    }
}
