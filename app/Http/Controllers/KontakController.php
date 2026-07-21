<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KontakController extends Controller
{
    public function store(Request $request)
    {
        $jenisPesan = $request->input('jenis_pesan');

        // Validasi base (semua jenis pesan)
        $rules = [
            'jenis_pesan' => ['required', 'string', 'in:pertanyaan_umum,pengaduan,kerja_sama,pengajuan_acara'],
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
                ]);
                break;

            case 'kerja_sama':
                $rules = array_merge($rules, [
                    'no_whatsapp'    => ['required', 'string', 'max:20'],
                    'email'          => ['required', 'email', 'max:255'],
                    'nama_instansi'  => ['required', 'string', 'max:255'],
                    'message'        => ['required', 'string'],
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
            $data['message'] = $data['deskripsi_acara'] ?? $request->input('message') ?? '-';
        }

        // Database compatibility fallback for pengajuan_acara
        if ($jenisPesan === 'pengajuan_acara' && isset($data['deskripsi_acara'])) {
            $data['message'] = $data['deskripsi_acara'];
            $data['subject'] = 'Pengajuan Acara: ' . $data['nama_acara'];
        }

        $pesan = Pesan::create($data);

        $successMessages = [
            'pertanyaan_umum' => 'Pertanyaan Anda berhasil dikirim! Kami akan segera menghubungi Anda.',
            'pengaduan'       => 'Pengaduan Anda berhasil kami terima! Terima kasih atas masukan Anda.',
            'kerja_sama'      => 'Proposal kerja sama Anda berhasil kami terima! Tim akan menghubungi Anda segera.',
            'pengajuan_acara' => 'Pengajuan acara Anda berhasil kami terima! Kami akan segera memproses permohonan Anda.',
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
