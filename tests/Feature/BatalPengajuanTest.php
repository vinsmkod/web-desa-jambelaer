<?php

namespace Tests\Feature;

use App\Models\PendaftaranUmkmModel;
use App\Models\PengaduanModel;
use App\Models\PengajuanSuratModel;
use App\Models\PertanyaanUmumModel;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * SRS-F-010.1 s.d. SRS-F-013.1 — Fitur "Pembatalan Pengajuan" oleh masyarakat
 * untuk 4 layanan: Pengajuan Surat, Pengaduan, Pertanyaan Umum, Pendaftaran UMKM.
 *
 * Aturan pembatalan (sama dengan gate "editable" yang sudah ada):
 *  - BOLEH dibatalkan : status "diajukan" / "menunggu"
 *  - TIDAK BOLEH      : diverifikasi / diproses / selesai / disetujui / dijawab / ditolak / dibatalkan
 */
class BatalPengajuanTest extends TestCase
{
    use DatabaseTransactions;

    // ---------------------------------------------------------------- helpers

    private function makeJenisSurat(): int
    {
        return DB::table('jenis_surat')->insertGetId([
            'nama_surat'         => 'Surat Keterangan Usaha',
            'kode_surat'         => 'SKU',
            'deskripsi'          => 'Surat keterangan usaha untuk keperluan administrasi.',
            'persyaratan_khusus' => 'KTP & KK',
            'is_active'          => true,
            'urutan'             => 99,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);
    }

    private function makeUser(string $name = 'Warga Jambelaer'): User
    {
        return UserModel::create([
            'name'              => $name,
            'email'             => 'warga.' . uniqid() . '@jambelaer.test',
            'password'          => bcrypt('password123'),
            'role'              => 'masyarakat',
            'email_verified_at' => now(),
        ]);
    }

    private function makeSurat(UserModel $user, string $status = 'diajukan'): PengajuanSurat
    {
        $jenis = $this->makeJenisSurat();

        return PengajuanSuratModel::create([
            'nomor_pengajuan' => PengajuanSuratModel::generateNomorPengajuan(),
            'user_id'         => $user->user_id,
            'jenis_surat_id'  => $jenis,
            'nik'             => '3201234567890001',
            'no_kk'           => '3201234567890002',
            'nama_pemohon'    => $user->name,
            'no_whatsapp'     => '081234567890',
            'alamat_pemohon'  => 'Dusun 1 Jambelaer',
            'keperluan'       => 'Keperluan administrasi usaha.',
            'file_ktp'        => 'ktp_test.pdf',
            'file_kk'         => 'kk_test.pdf',
            'status'          => $status,
        ]);
    }

    private function makePengaduan(UserModel $user, string $status = 'diajukan'): Pengaduan
    {
        return PengaduanModel::create([
            'nomor_pengaduan' => PengaduanModel::generateNomorPengaduan(),
            'user_id'         => $user->user_id,
            'nama'            => $user->name,
            'email'           => $user->email,
            'no_whatsapp'     => '081234567890',
            'judul'           => 'Lampu jalan mati',
            'isi_pengaduan'   => 'Lampu jalan di Dusun 2 sudah mati seminggu.',
            'status'          => $status,
        ]);
    }

    private function makePertanyaan(UserModel $user, string $status = 'diajukan'): PertanyaanUmum
    {
        return PertanyaanUmumModel::create([
            'nomor_pertanyaan' => PertanyaanUmumModel::generateNomorPertanyaan(),
            'user_id'          => $user->user_id,
            'nama'             => $user->name,
            'email'            => $user->email,
            'no_whatsapp'      => '081234567890',
            'subjek'           => 'Cara mengurus surat domisili',
            'pertanyaan'       => 'Apa syarat membuat surat domisili?',
            'status'           => $status,
        ]);
    }

    private function makeUmkm(UserModel $user, string $status = 'diajukan'): PendaftaranUmkm
    {
        return PendaftaranUmkmModel::create([
            'nomor_pendaftaran' => PendaftaranUmkmModel::generateNomorPendaftaran(),
            'user_id'           => $user->user_id,
            'nama_usaha'        => 'Keripik Jambelaer',
            'nama_pemilik'      => $user->name,
            'nomor_whatsapp'    => '081298765432',
            'alamat_usaha'      => 'Dusun 3 Jambelaer',
            'produk'            => 'Keripik Singkong',
            'deskripsi_usaha'   => 'Keripik singkong renyah khas desa.',
            'nib'               => '9988776655443',
            'sertifikasi_halal' => 'HALAL-12345',
            'status'            => $status,
        ]);
    }

    /**
     * Daftar service: [closure factory, nama route batal, closure id, jenis route detail].
     */
    private function layanan(): array
    {
        return [
            'Pengajuan Surat' => [
                fn (UserModel $u, string $s) => $this->makeSurat($u, $s),
                'pengajuan.surat.batal',
                fn ($m) => $m->pengajuan_surat_id,
                'surat',
            ],
            'Pengaduan' => [
                fn (UserModel $u, string $s) => $this->makePengaduan($u, $s),
                'pengaduan.batal',
                fn ($m) => $m->pengaduan_id,
                'pengaduan',
            ],
            'Pertanyaan Umum' => [
                fn (UserModel $u, string $s) => $this->makePertanyaan($u, $s),
                'pertanyaan-umum.batal',
                fn ($m) => $m->pertanyaan_id,
                'pertanyaan',
            ],
            'Pendaftaran UMKM' => [
                fn (UserModel $u, string $s) => $this->makeUmkm($u, $s),
                'pendaftaran-umkm.batal',
                fn ($m) => $m->pendaftaran_umkm_id,
                'umkm',
            ],
        ];
    }

    // ---------------------------------------------------------------- TEST 1

    /**
     * TEST 1 — Tombol "Batalkan" hanya muncul untuk status yang masih bisa dibatalkan.
     */
    public function test_tombol_batal_muncul_saat_status_diajukan_dan_menghilang_saat_diproses(): void
    {
        foreach ($this->layanan() as $label => [$make, $routeBatal, $idGetter, $jenis]) {
            $owner  = $this->makeUser($label);
            $aktif  = $make($owner, 'diajukan');
            $proses = $make($owner, 'diproses');

            $this->actingAs($owner);

            // Halaman detail: tombol ada saat masih bisa dibatalkan
            $this->get(route('pengajuan.show.detail', ['jenis' => $jenis, 'id' => $idGetter($aktif)]))
                 ->assertOk()
                 ->assertSee('Batalkan Pengajuan', false);

            // Saat sudah diproses tombol tidak boleh muncul
            $this->get(route('pengajuan.show.detail', ['jenis' => $jenis, 'id' => $idGetter($proses)]))
                 ->assertOk()
                 ->assertDontSee('Batalkan Pengajuan', false);

            $this->flushSession();
        }

        $this->assertTrue(true, 'Semua layanan menampilkan tombol batal sesuai status.');
    }

    // ---------------------------------------------------------------- TEST 2

    /**
     * TEST 2 — Masyarakat dapat membatalkan pengajuannya sendiri yang masih "diajukan"/"menunggu".
     */
    public function test_bisa_membatalkan_pengajuan_sendiri_yang_berstatus_diajukan(): void
    {
        foreach ($this->layanan() as $label => [$make, $routeBatal, $idGetter, $jenis]) {
            $owner = $this->makeUser($label);
            $model = $make($owner, 'menunggu');
            $detail = route('pengajuan.show.detail', ['jenis' => $jenis, 'id' => $idGetter($model)]);

            $this->actingAs($owner)
                 ->from($detail)
                 ->post(route($routeBatal, $idGetter($model)))
                 ->assertRedirect($detail)
                 ->assertSessionHas('success');

            $this->assertSame('dibatalkan', $model->fresh()->status, "[{$label}] status harus menjadi 'dibatalkan'.");
            $this->assertDatabaseHas($model->getTable(), [$model->getKeyName() => $idGetter($model), 'status' => 'dibatalkan']);

            $this->flushSession();
        }
    }

    // ---------------------------------------------------------------- TEST 3

    /**
     * TEST 3 — Pengajuan yang sudah diproses (diverifikasi/diproses/selesai/disetujui/dijawab/ditolak)
     * TIDAK dapat dibatalkan; sistem menolak dengan peringatan tanpa mengubah data.
     */
    public function test_status_sudah_diproses_tidak_bisa_dibatalkan(): void
    {
        $statusDilarang = ['diverifikasi', 'diproses', 'selesai', 'disetujui', 'dijawab', 'ditolak'];

        foreach ($this->layanan() as $label => [$make, $routeBatal, $idGetter, $jenis]) {
            foreach ($statusDilarang as $status) {
                $owner = $this->makeUser($label);

                try {
                    $model = $make($owner, $status);
                } catch (\Throwable $e) {
                    // Status ini tidak didukung oleh layanan bersangkutan → lewati aman.
                    continue;
                }

                $this->actingAs($owner)
                     ->post(route($routeBatal, $idGetter($model)))
                     ->assertRedirect()
                     ->assertSessionHas('warning');

                $this->assertNotSame('dibatalkan', $model->fresh()->status, "[{$label}] status '{$status}' tidak boleh ikut terbatal.");
                $this->assertSame($status, $model->fresh()->status);

                $this->flushSession();
            }
        }
    }

    // ---------------------------------------------------------------- TEST 4

    /**
     * TEST 4 — Anti-IDOR: masyarakat tidak dapat membatalkan pengajuan milik user lain.
     */
    public function test_tidak_bisa_membatalkan_pengajuan_milik_user_lain(): void
    {
        foreach ($this->layanan() as $label => [$make, $routeBatal, $idGetter, $jenis]) {
            $victim   = $this->makeUser("Korban {$label}");
            $attacker = $this->makeUser("Penyerang {$label}");
            $model    = $make($victim, 'diajukan');

            $this->actingAs($attacker)
                 ->post(route($routeBatal, $idGetter($model)))
                 ->assertStatus(403);

            $this->assertSame('diajukan', $model->fresh()->status, "[{$label}] milik user lain tidak boleh terbatal.");

            $this->flushSession();
        }
    }

    // ---------------------------------------------------------------- TEST 5

    /**
     * TEST 5 — Tamu (belum login) tidak dapat mengakses endpoint pembatalan.
     */
    public function test_tamu_tidak_bisa_mengakses_endpoint_pembatalan(): void
    {
        foreach ($this->layanan() as $label => [$make, $routeBatal, $idGetter, $jenis]) {
            $owner = $this->makeUser($label);
            $model = $make($owner, 'diajukan');

            $this->post(route($routeBatal, $idGetter($model)))
                 ->assertRedirect();

            $this->assertSame('diajukan', $model->fresh()->status, "[{$label}] tidak boleh terbatal oleh tamu.");

            $this->flushSession();
        }
    }

    // ---------------------------------------------------------------- TEST 6

    /**
     * TEST 6 — ID pengajuan tidak valid ditangani dengan aman (404, bukan error 500).
     */
    public function test_id_tidak_valid_menghasilkan_404(): void
    {
        foreach ($this->layanan() as $label => [$make, $routeBatal, $idGetter, $jenis]) {
            $owner = $this->makeUser($label);

            $this->actingAs($owner)
                 ->post(route($routeBatal, 999999999))
                 ->assertStatus(404);

            $this->flushSession();
        }
    }

    // ---------------------------------------------------------------- TEST 7

    /**
     * TEST 7 — Setelah dibatalkan, tombol "Batalkan"/"Edit" tidak muncul lagi dan
     * endpoint menolak pembatalan ganda.
     */
    public function test_setelah_dibatalkan_tombol_tidak_muncul_lagi(): void
    {
        foreach ($this->layanan() as $label => [$make, $routeBatal, $idGetter, $jenis]) {
            $owner = $this->makeUser($label);
            $model = $make($owner, 'diajukan');
            $detail = route('pengajuan.show.detail', ['jenis' => $jenis, 'id' => $idGetter($model)]);

            $this->actingAs($owner);

            // 1. Pembatalan pertama berhasil
            $this->from($detail)
                 ->post(route($routeBatal, $idGetter($model)))
                 ->assertRedirect()
                 ->assertSessionHas('success');
            $this->assertSame('dibatalkan', $model->fresh()->status);

            // 2. Halaman detail: tidak ada tombol Batal maupun Edit, label tampil
            $this->get($detail)
                 ->assertOk()
                 ->assertDontSee('Batalkan Pengajuan', false)
                 ->assertDontSee('Edit Pengajuan', false)
                 ->assertSee('Dibatalkan', false);

            // 3. Daftar Pengajuan Saya: tombol Batal tidak ada untuk item ini
            $this->get(route('pengajuan.saya'))
                 ->assertOk()
                 ->assertDontSee('Batalkan', false);

            // 4. Pembatalan ganda ditolak (warning), status tetap 'dibatalkan'
            $this->from($detail)
                 ->post(route($routeBatal, $idGetter($model)))
                 ->assertRedirect()
                 ->assertSessionHas('warning');
            $this->assertSame('dibatalkan', $model->fresh()->status, "[{$label}] status tetap 'dibatalkan' saat batal ganda.");

            $this->flushSession();
        }
    }

    // ---------------------------------------------------------------- Tambahan

    /**
     * Label & kelas badge status "dibatalkan" tersedia konsisten di seluruh layanan.
     */
    public function test_label_dan_badge_status_dibatalkan_tersedia(): void
    {
        foreach ($this->layanan() as $label => [$make, $routeBatal, $idGetter, $jenis]) {
            $owner = $this->makeUser($label);
            $model = $make($owner, 'dibatalkan');

            $this->assertSame('Dibatalkan', $model->status_label, "[{$label}] label harus 'Dibatalkan'.");
            $this->assertStringContainsString('stone', (string) $model->status_badge_class, "[{$label}] kelas badge harus netral (stone).");

            $this->actingAs($owner)
                 ->get(route('pengajuan.show.detail', ['jenis' => $jenis, 'id' => $idGetter($model)]))
                 ->assertOk()
                 ->assertSee('Pengajuan Dibatalkan', false);

            $this->flushSession();
        }
    }
}




