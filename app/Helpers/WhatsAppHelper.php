<?php

namespace App\Helpers;

use App\Models\AgendaAcara;
use App\Models\Produk;
use App\Models\Pengaturan;

/**
 * WhatsAppHelper
 *
 * Helper terpusat untuk membuat URL WhatsApp dengan pesan dinamis.
 * Menghindari duplikasi kode di controller & view.
 *
 * Penggunaan di Blade:
 *   {{ \App\Helpers\WhatsAppHelper::url($nomor, $pesan) }}
 */
class WhatsAppHelper
{
    /**
     * Bersihkan nomor WA dan konversi ke format internasional (62xxx).
     */
    public static function cleanPhone(string $phone): string
    {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        }
        return $clean;
    }

    /**
     * Buat URL WhatsApp dengan pesan ter-encode.
     */
    public static function url(string $phone, string $message): string
    {
        $phone   = self::cleanPhone($phone);
        $encoded = rawurlencode($message);
        return "https://wa.me/{$phone}?text={$encoded}";
    }

    /**
     * Nomor WhatsApp admin/kantor desa dari pengaturan.
     */
    public static function adminPhone(): string
    {
        return Pengaturan::get('sosmed_whatsapp', '');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Pesan dinamis per konteks
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Pesan WA admin ke pemohon pengaduan.
     */
    public static function msgPengaduanKePemohon(object $pengaduan): string
    {
        return "Halo Bapak/Ibu {$pengaduan->nama},\n\n"
            . "Kami dari Pemerintah Desa Jambelaer telah menerima pengaduan Anda.\n\n"
            . "Subjek   : {$pengaduan->judul}\n"
            . "Nomor    : {$pengaduan->nomor_pengaduan}\n"
            . "Status   : " . ucfirst($pengaduan->status ?? 'diajukan') . "\n\n"
            . "Kami akan segera menindaklanjuti pengaduan Anda.\n\n"
            . "Terima kasih.";
    }

    /**
     * Pesan WA admin ke pemohon pengajuan acara.
     */
    public static function msgPengajuanAcaraKePemohon(AgendaAcara $acara): string
    {
        $statusLabel = [
            'menunggu'  => 'Menunggu Verifikasi',
            'disetujui' => 'Disetujui',
            'ditolak'   => 'Ditolak',
        ];
        $status = $statusLabel[$acara->status ?? 'menunggu'] ?? ucfirst($acara->status ?? 'menunggu');

        return "Halo Bapak/Ibu {$acara->name},\n\n"
            . "Kami dari Pemerintah Desa Jambelaer menginformasikan perkembangan pengajuan acara Anda.\n\n"
            . "Nama Acara : {$acara->nama_acara}\n"
            . "Tanggal    : " . ($acara->tanggal_acara ? $acara->tanggal_acara->translatedFormat('d F Y') : '-') . "\n"
            . "Status     : {$status}\n\n"
            . "Untuk informasi lebih lanjut, silakan hubungi kantor Pemerintah Desa Jambelaer.\n\n"
            . "Terima kasih.";
    }

    /**
     * Pesan WA dari pengunjung ke pemilik UMKM.
     * Digunakan di halaman detail UMKM (publik).
     */
    public static function msgUmkm(Produk $produk): string
    {
        return "Halo, saya mendapatkan informasi mengenai produk *{$produk->title}* dari Website Desa Jambelaer.\n\n"
            . "Pelaku UMKM : {$produk->producer}\n"
            . ($produk->price ? "Harga       : {$produk->price}\n" : "")
            . "\nSaya ingin mendapatkan informasi lebih lanjut mengenai produk tersebut.\n\n"
            . "Terima kasih.";
    }

    /**
     * URL WA langsung ke nomor admin desa untuk kontak umum.
     */
    public static function urlAdminUmum(string $konteks = ''): string
    {
        $phone = self::adminPhone();
        if (!$phone) return '#';
        $msg = "Halo Admin Desa Jambelaer,\n\n" . ($konteks ?: "Saya ingin mendapatkan informasi mengenai layanan desa.") . "\n\nTerima kasih.";
        return self::url($phone, $msg);
    }
}
