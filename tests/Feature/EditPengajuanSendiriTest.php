<?php

namespace Tests\Feature;

use App\Models\JenisSuratModel;
use App\Models\PengaduanModel;
use App\Models\PengajuanSuratModel;
use App\Models\PertanyaanUmumModel;
use App\Models\PendaftaranUmkmModel;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EditPengajuanSendiriTest extends TestCase
{
    use DatabaseTransactions;

    private function makeMasyarakat(string $name = 'Warga Edit'): User
    {
        return UserModel::create([
            'name'     => $name . ' ' . uniqid(),
            'email'    => 'edit_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'masyarakat',
        ]);
    }

    private function makeJenisSurat(): JenisSurat
    {
        return JenisSuratModel::first() ?: JenisSuratModel::create([
            'nama_surat'  => 'Surat Keterangan Domisili',
            'kode_surat'  => 'SKD',
            'deskripsi'   => 'Surat keterangan tempat tinggal',
            'is_active'   => true,
            'urutan'      => 1,
        ]);
    }

    private function makeSurat(UserModel $user, string $status = 'diajukan'): PengajuanSurat
    {
        return PengajuanSuratModel::create([
            'nomor_pengajuan' => PengajuanSuratModel::generateNomorPengajuan(),
            'user_id'         => $user->user_id,
            'jenis_surat_id'  => $this->makeJenisSurat()->id,
            'nik'             => '3201234567890001',
            'no_kk'           => '3201234567890002',
            'nama_pemohon'    => $user->name,
            'no_whatsapp'     => '081234567890',
            'alamat_pemohon'  => 'Dusun 1 Jambelaer',
            'keperluan'       => 'Keperluan administrasi sekolah',
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
            'isi_pengaduan'   => 'Lampu penerangan jalan di Dusun 2 mati sejak seminggu.',
            'lokasi'          => 'Dusun 2 Jambelaer',
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
            'subjek'           => 'Cara mengurus surat keterangan',
            'pertanyaan'       => 'Apa saja syarat untuk mengurus surat keterangan domisili?',
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
     * 1. Pemilik dapat membuka keempat form edit (GET 200) dan melihat data lama terisi.
     */
    public function test_owner_can_open_all_four_edit_forms(): void
    {
        Storage::fake('public');
        $owner = $this->makeMasyarakat();

        $surat       = $this->makeSurat($owner);
        $pengaduan   = $this->makePengaduan($owner);
        $pertanyaan  = $this->makePertanyaan($owner);
        $umkm        = $this->makeUmkm($owner);

        // Form edit surat
        $r1 = $this->actingAs($owner)->get(route('pengajuan.surat.edit', $surat->pengajuan_surat_id));
        $r1->assertStatus(200);
        $r1->assertSee($surat->keperluan, false);
        $r1->assertSee($surat->nik, false);

        // Form edit pengaduan
        $r2 = $this->actingAs($owner)->get(route('pengaduan.edit', $pengaduan->pengaduan_id));
        $r2->assertStatus(200);
        $r2->assertSee($pengaduan->judul, false);
        $r2->assertSee($pengaduan->isi_pengaduan, false);

        // Form edit pertanyaan umum
        $r3 = $this->actingAs($owner)->get(route('pertanyaan-umum.edit', $pertanyaan->pertanyaan_id));
        $r3->assertStatus(200);
        $r3->assertSee($pertanyaan->subjek, false);
        $r3->assertSee($pertanyaan->pertanyaan, false);

        // Form edit pendaftaran UMKM
        $r4 = $this->actingAs($owner)->get(route('pendaftaran-umkm.edit', $umkm->pendaftaran_umkm_id));
        $r4->assertStatus(200);
        $r4->assertSee($umkm->nama_usaha, false);
        $r4->assertSee($umkm->nib, false);
        $r4->assertSee($umkm->sertifikasi_halal, false);
    }

    /**
     * 2. Pemilik dapat memperbarui keempat layanan; data tersimpan & redirect ke detail.
     */
    public function test_owner_can_update_all_four_services(): void
    {
        Storage::fake('public');
        $owner = $this->makeMasyarakat();

        // 2a. Surat
        $surat = $this->makeSurat($owner);
        $res = $this->actingAs($owner)->put(route('pengajuan.surat.update', $surat->pengajuan_surat_id), [
            'jenis_surat_id'      => $surat->jenis_surat_id,
            'name'                => 'Nama Baru Pemohon',
            'nik'                 => '3209876543210001',
            'no_kk'               => '3209876543210002',
            'no_whatsapp'         => '081300000001',
            'alamat_pemohon'      => 'Dusun 4 Jambelaer (pindahan)',
            'keperluan'           => 'Keperluan pengajuan beasiswa',
            'keterangan_tambahan' => 'Diperbarui via unit test',
        ]);
        $res->assertRedirect(route('pengajuan.show.detail', ['jenis' => 'surat', 'id' => $surat->pengajuan_surat_id]));
        $res->assertSessionHas('success');
        $surat->refresh();
        $this->assertSame('Nama Baru Pemohon', $surat->nama_pemohon);
        $this->assertSame('3209876543210001', $surat->nik);
        $this->assertSame('Keperluan pengajuan beasiswa', $surat->keperluan);

        // 2b. Pengaduan
        $pengaduan = $this->makePengaduan($owner);
        $res = $this->actingAs($owner)->put(route('pengaduan.update', $pengaduan->pengaduan_id), [
            'nama'          => 'Warga Pengadu Update',
            'no_whatsapp'   => '081300000002',
            'judul'         => 'Jalan rusak parah',
            'isi_pengaduan' => 'Tolong segera diperbaiki jalan utama menuju balai desa.',
            'lokasi'        => 'Jalan utama desa',
        ]);
        $res->assertRedirect(route('pengajuan.show.detail', ['jenis' => 'pengaduan', 'id' => $pengaduan->pengaduan_id]));
        $res->assertSessionHas('success');
        $pengaduan->refresh();
        $this->assertSame('Jalan rusak parah', $pengaduan->judul);
        $this->assertSame('Jalan utama desa', $pengaduan->lokasi);

        // 2c. Pertanyaan umum
        $pertanyaan = $this->makePertanyaan($owner);
        $res = $this->actingAs($owner)->put(route('pertanyaan-umum.update', $pertanyaan->pertanyaan_id), [
            'nama'        => 'Warga Bertanya Update',
            'no_whatsapp' => '081300000003',
            'subjek'      => 'Syarat pembuatan akta kelahiran',
            'pertanyaan'  => 'Dokumen apa saja yang harus dibawa untuk membuat akta kelahiran bayi?',
        ]);
        $res->assertRedirect(route('pengajuan.show.detail', ['jenis' => 'pertanyaan', 'id' => $pertanyaan->pertanyaan_id]));
        $res->assertSessionHas('success');
        $pertanyaan->refresh();
        $this->assertSame('Syarat pembuatan akta kelahiran', $pertanyaan->subjek);
        $this->assertStringContainsString('akta kelahiran bayi', $pertanyaan->pertanyaan);

        // 2d. Pendaftaran UMKM
        $umkm = $this->makeUmkm($owner);
        $res = $this->actingAs($owner)->put(route('pendaftaran-umkm.update', $umkm->pendaftaran_umkm_id), [
            'nama_usaha'        => 'Kopi Jambelaer',
            'nama_pemilik'      => 'Pemilik Update',
            'alamat_usaha'      => 'Dusun 1 Jambelaer',
            'deskripsi_usaha'   => 'Kopi robusta khas pegunungan Jambelaer.',
            'produk'            => 'Biji Kopi Robusta',
            'nomor_whatsapp'    => '081300000004',
            'instagram'         => '@kopijambelaer',
            'nib'               => '1122334455667',
            'sertifikasi_halal' => 'HALAL-99999',
        ]);
        $res->assertRedirect(route('pengajuan.show.detail', ['jenis' => 'umkm', 'id' => $umkm->pendaftaran_umkm_id]));
        $res->assertSessionHas('success');
        $umkm->refresh();
        $this->assertSame('Kopi Jambelaer', $umkm->nama_usaha);
        $this->assertSame('1122334455667', $umkm->nib);
        $this->assertSame('HALAL-99999', $umkm->sertifikasi_halal);
    }

    /**
     * 3. IDOR: user lain tidak dapat melihat form edit maupun memperbarui pengajuan orang lain (403).
     */
    public function test_other_user_cannot_edit_or_update_others_submissions(): void
    {
        Storage::fake('public');
        $owner    = $this->makeMasyarakat('Pemilik Asli');
        $attacker = $this->makeMasyarakat('Penyusup');

        $surat      = $this->makeSurat($owner);
        $pengaduan  = $this->makePengaduan($owner);
        $pertanyaan = $this->makePertanyaan($owner);
        $umkm       = $this->makeUmkm($owner);

        // GET form milik orang lain -> 403
        $this->actingAs($attacker)->get(route('pengajuan.surat.edit', $surat->pengajuan_surat_id))->assertStatus(403);
        $this->actingAs($attacker)->get(route('pengaduan.edit', $pengaduan->pengaduan_id))->assertStatus(403);
        $this->actingAs($attacker)->get(route('pertanyaan-umum.edit', $pertanyaan->pertanyaan_id))->assertStatus(403);
        $this->actingAs($attacker)->get(route('pendaftaran-umkm.edit', $umkm->pendaftaran_umkm_id))->assertStatus(403);

        // PUT data milik orang lain -> 403 dan data tidak berubah
        $this->actingAs($attacker)->put(route('pengajuan.surat.update', $surat->pengajuan_surat_id), [
            'jenis_surat_id' => $surat->jenis_surat_id,
            'name'           => 'Diretas',
            'nik'            => '0000000000000001',
            'no_kk'          => '0000000000000002',
            'no_whatsapp'    => '080000000001',
            'alamat_pemohon' => 'Alamat Diretas',
            'keperluan'      => 'Diretas',
        ])->assertStatus(403);

        $this->actingAs($attacker)->put(route('pengaduan.update', $pengaduan->pengaduan_id), [
            'nama' => 'Diretas', 'no_whatsapp' => '080000000002', 'judul' => 'Diretas', 'isi_pengaduan' => 'Diretas',
        ])->assertStatus(403);

        $this->actingAs($attacker)->put(route('pertanyaan-umum.update', $pertanyaan->pertanyaan_id), [
            'nama' => 'Diretas', 'no_whatsapp' => '080000000003', 'subjek' => 'Diretas', 'pertanyaan' => 'Diretas',
        ])->assertStatus(403);

        $this->actingAs($attacker)->put(route('pendaftaran-umkm.update', $umkm->pendaftaran_umkm_id), [
            'nama_usaha' => 'Diretas', 'nama_pemilik' => 'Diretas', 'alamat_usaha' => 'Diretas',
            'deskripsi_usaha' => 'Diretas', 'produk' => 'Diretas', 'nomor_whatsapp' => '080000000004',
        ])->assertStatus(403);

        // Pastikan data pemilik asli tidak berubah sama sekali
        $this->assertSame('Keperluan administrasi sekolah', $surat->fresh()->keperluan);
        $this->assertSame('Lampu jalan mati', $pengaduan->fresh()->judul);
        $this->assertSame('Cara mengurus surat keterangan', $pertanyaan->fresh()->subjek);
        $this->assertSame('Keripik Jambelaer', $umkm->fresh()->nama_usaha);
    }

    /**
     * 4. Pengajuan yang sudah diproses tidak dapat diedit/diupdate (redirect + warning).
     */
    public function test_processed_submission_cannot_be_edited(): void
    {
        Storage::fake('public');
        $owner = $this->makeMasyarakat();

        $surat      = $this->makeSurat($owner, 'diproses');
        $pengaduan  = $this->makePengaduan($owner, 'selesai');
        $pertanyaan = $this->makePertanyaan($owner, 'dijawab');
        $umkm       = $this->makeUmkm($owner, 'disetujui');

        // GET form -> redirect ke detail dengan warning
        $this->actingAs($owner)->get(route('pengajuan.surat.edit', $surat->pengajuan_surat_id))
            ->assertRedirect(route('pengajuan.show.detail', ['jenis' => 'surat', 'id' => $surat->pengajuan_surat_id]))
            ->assertSessionHas('warning');

        $this->actingAs($owner)->get(route('pengaduan.edit', $pengaduan->pengaduan_id))
            ->assertRedirect(route('pengajuan.show.detail', ['jenis' => 'pengaduan', 'id' => $pengaduan->pengaduan_id]))
            ->assertSessionHas('warning');

        $this->actingAs($owner)->get(route('pertanyaan-umum.edit', $pertanyaan->pertanyaan_id))
            ->assertRedirect(route('pengajuan.show.detail', ['jenis' => 'pertanyaan', 'id' => $pertanyaan->pertanyaan_id]))
            ->assertSessionHas('warning');

        $this->actingAs($owner)->get(route('pendaftaran-umkm.edit', $umkm->pendaftaran_umkm_id))
            ->assertRedirect(route('pengajuan.show.detail', ['jenis' => 'umkm', 'id' => $umkm->pendaftaran_umkm_id]))
            ->assertSessionHas('warning');

        // PUT -> redirect dengan warning, data tidak berubah
        $this->actingAs($owner)->put(route('pengajuan.surat.update', $surat->pengajuan_surat_id), [
            'jenis_surat_id' => $surat->jenis_surat_id,
            'name'           => 'Ubah Paksa',
            'nik'            => '3200000000000001',
            'no_kk'          => '3200000000000002',
            'no_whatsapp'    => '081111111111',
            'alamat_pemohon' => 'Ubah paksa',
            'keperluan'      => 'Ubah paksa',
        ])->assertRedirect()->assertSessionHas('warning');

        $this->assertSame('Keperluan administrasi sekolah', $surat->fresh()->keperluan);
        $this->assertSame('diproses', $surat->fresh()->status);
    }

    /**
     * 5. Tamu (belum login) diarahkan ke halaman login untuk semua route edit/update.
     */
    public function test_guest_cannot_access_edit_routes(): void
    {
        $this->get(route('pengaduan.edit', 1))->assertRedirect('/login');
        $this->put(route('pengaduan.update', 1), [])->assertRedirect('/login');
        $this->get(route('pertanyaan-umum.edit', 1))->assertRedirect('/login');
        $this->put(route('pertanyaan-umum.update', 1), [])->assertRedirect('/login');
        $this->get(route('pendaftaran-umkm.edit', 1))->assertRedirect('/login');
        $this->put(route('pendaftaran-umkm.update', 1), [])->assertRedirect('/login');

        $owner = $this->makeMasyarakat();
        $surat = $this->makeSurat($owner);
        $this->get(route('pengajuan.surat.edit', $surat->pengajuan_surat_id))->assertRedirect('/login');
        $this->put(route('pengajuan.surat.update', $surat->pengajuan_surat_id), [])->assertRedirect('/login');
    }

    /**
     * 6. Berkas lama (KTP/KK & foto bukti) tetap dipertahankan jika tidak ada unggahan baru.
     */
    public function test_old_files_preserved_when_no_new_upload(): void
    {
        Storage::fake('public');

        $owner = $this->makeMasyarakat();

        // Surat dengan KTP & KK sudah terlanjur tersimpan
        $surat = $this->makeSurat($owner);
        $ktp = UploadedFile::fake()->create('ktp_lama.pdf', 100, 'application/pdf');
        $kk  = UploadedFile::fake()->create('kk_lama.pdf', 100, 'application/pdf');
        $surat->file_ktp = $ktp->store('pengajuan-surat/ktp', 'public');
        $surat->file_kk  = $kk->store('pengajuan-surat/kk', 'public');
        $surat->save();

        $ktpLama = $surat->file_ktp;
        $kkLama  = $surat->file_kk;

        // Update tanpa mengunggah berkas baru
        $this->actingAs($owner)->put(route('pengajuan.surat.update', $surat->pengajuan_surat_id), [
            'jenis_surat_id' => $surat->jenis_surat_id,
            'name'           => 'Cuma Ganti Nama',
            'nik'            => '3201234567890001',
            'no_kk'          => '3201234567890002',
            'no_whatsapp'    => '081234567890',
            'alamat_pemohon' => 'Dusun 1 Jambelaer',
            'keperluan'      => 'Keperluan administrasi sekolah',
        ])->assertSessionHas('success');

        $surat->refresh();
        $this->assertSame($ktpLama, $surat->file_ktp, 'Berkas KTP lama harus tetap ada');
        $this->assertSame($kkLama, $surat->file_kk, 'Berkas KK lama harus tetap ada');
        $this->assertTrue(Storage::disk('public')->exists($ktpLama));
        $this->assertTrue(Storage::disk('public')->exists($kkLama));

        // Pengaduan dengan foto bukti lama
        $pengaduan = $this->makePengaduan($owner);
        $pengaduan->foto_bukti = UploadedFile::fake()->create('bukti_lama.png', 100)->store('pengaduan', 'public');
        $pengaduan->save();
        $fotoLama = $pengaduan->foto_bukti;

        $this->actingAs($owner)->put(route('pengaduan.update', $pengaduan->pengaduan_id), [
            'nama' => $owner->name, 'no_whatsapp' => '081234567890',
            'judul' => 'Lampu jalan mati', 'isi_pengaduan' => 'Saya menambah keterangan baru tanpa ganti foto.',
            'lokasi' => 'Dusun 2 Jambelaer',
        ])->assertSessionHas('success');

        $pengaduan->refresh();
        $this->assertSame($fotoLama, $pengaduan->foto_bukti, 'Foto bukti lama harus tetap ada');
        $this->assertTrue(Storage::disk('public')->exists($fotoLama));
    }

    /**
     * 7. NIB & Sertifikasi Halal UMKM yang sudah ada tidak terhapus saat kolom dikosongkan.
     *
     * Skrip sebelumnya berbug: `$umkm->nib = $request->input('nib')` menghapus NIB lama
     * setiap kali form dikirim tanpa mengisi ulang kolom teks. Helper
     * updateFieldBerkasAtauTeks() sekarang mempertahankan nilai lama ketika kosong.
     */
    public function test_umkm_nib_and_halal_preserved_when_blank(): void
    {
        Storage::fake('public');
        $owner = $this->makeMasyarakat();
        $umkm  = $this->makeUmkm($owner);

        // Update dengan NIB & sertifikasi dikosongkan (mis. user hanya ganti nomor WhatsApp)
        $this->actingAs($owner)->put(route('pendaftaran-umkm.update', $umkm->pendaftaran_umkm_id), [
            'nama_usaha'        => 'Keripik Jambelaer',
            'nama_pemilik'      => $umkm->nama_pemilik,
            'alamat_usaha'      => 'Dusun 3 Jambelaer',
            'deskripsi_usaha'   => 'Keripik singkong renyah khas desa.',
            'produk'            => 'Keripik Singkong',
            'nomor_whatsapp'    => '081299988877',
            'nib'               => '',
            'sertifikasi_halal' => '',
        ])->assertSessionHas('success');

        $umkm->refresh();
        $this->assertSame('9988776655443', $umkm->nib, 'NIB lama harus dipertahankan, bukan di-null-kan');
        $this->assertSame('HALAL-12345', $umkm->sertifikasi_halal, 'Sertifikasi halal lama harus dipertahankan');
        $this->assertSame('081299988877', $umkm->nomor_whatsapp, 'Field lain tetap ikut diperbarui');
    }

    /**
     * 8. Unggah berkas baru menggantikan berkas lama: berkas lama dihapus dari storage.
     */
    public function test_uploading_new_file_deletes_old_file(): void
    {
        Storage::fake('public');
        $owner = $this->makeMasyarakat();

        // Surat: KTP lama tersimpan
        $surat = $this->makeSurat($owner);
        $surat->file_ktp = UploadedFile::fake()->create('ktp_lama.pdf', 100, 'application/pdf')
            ->store('pengajuan-surat/ktp', 'public');
        $surat->save();
        $ktpLama = $surat->file_ktp;
        $this->assertTrue(Storage::disk('public')->exists($ktpLama));

        // Unggah KTP baru
        $res = $this->actingAs($owner)->put(route('pengajuan.surat.update', $surat->pengajuan_surat_id), [
            'jenis_surat_id' => $surat->jenis_surat_id,
            'name'           => $surat->nama_pemohon,
            'nik'            => '3201234567890001',
            'no_kk'          => '3201234567890002',
            'no_whatsapp'    => '081234567890',
            'alamat_pemohon' => 'Dusun 1 Jambelaer',
            'keperluan'      => 'Keperluan administrasi sekolah',
            'file_ktp'       => UploadedFile::fake()->create('ktp_baru.pdf', 100, 'application/pdf'),
        ]);
        $res->assertSessionHas('success');

        $surat->refresh();
        $this->assertNotSame($ktpLama, $surat->file_ktp, 'KTP harus diganti dengan file baru');
        $this->assertFalse(Storage::disk('public')->exists($ktpLama), 'Berkas KTP lama harus dihapus dari storage');
        $this->assertTrue(Storage::disk('public')->exists($surat->file_ktp), 'Berkas KTP baru harus tersimpan');

        // UMKM: ganti NIB teks menjadi unggahan berkas — berkas teks lama (nilai teks) tidak
        // dianggap path storage, tapi memastikan path berkas baru tersimpan & bisa diakses.
        $umkm = $this->makeUmkm($owner);
        $res = $this->actingAs($owner)->put(route('pendaftaran-umkm.update', $umkm->pendaftaran_umkm_id), [
            'nama_usaha'      => 'Keripik Jambelaer',
            'nama_pemilik'    => $umkm->nama_pemilik,
            'alamat_usaha'    => 'Dusun 3 Jambelaer',
            'deskripsi_usaha' => 'Keripik singkong renyah khas desa.',
            'produk'          => 'Keripik Singkong',
            'nomor_whatsapp'  => '081298765432',
            'nib'             => UploadedFile::fake()->create('nib_scan.pdf', 100, 'application/pdf'),
        ]);
        $res->assertSessionHas('success');
        $umkm->refresh();
        $this->assertNotSame('9988776655443', $umkm->nib, 'NIB teks lama harus tergantikan oleh berkas');
        $this->assertTrue(Storage::disk('public')->exists($umkm->nib), 'Berkas NIB baru harus tersimpan');
    }

    /**
     * 9. Halaman publik Struktur Desa dapat diakses tanpa login.
     */
    public function test_struktur_desa_page_accessible_without_login(): void
    {
        $response = $this->get(route('struktur.desa'));
        $response->assertStatus(200);
    }

    /**
     * 10. Halaman "Pengajuan Saya" menampilkan tombol edit hanya untuk pengajuan yang masih editable.
     */
    public function test_pengajuan_saya_index_marks_editable_items(): void
    {
        $owner = $this->makeMasyarakat();

        $suratEditable   = $this->makeSurat($owner, 'diajukan');
        $suratDiproses   = $this->makeSurat($owner, 'selesai');
        $umkmEditable    = $this->makeUmkm($owner, 'menunggu');

        $response = $this->actingAs($owner)->get(route('pengajuan.saya'));
        $response->assertStatus(200);

        $items = $response->viewData('pengajuanList');

        $map = [];
        foreach ($items as $item) {
            $map[$item->nomor_tiket] = $item;
        }

        // Pengajuan yang masih dapat diubah → editable true & edit_url terisi & benar
        $this->assertTrue($map[$suratEditable->nomor_pengajuan]->editable);
        $this->assertSame(
            route('pengajuan.surat.edit', $suratEditable->pengajuan_surat_id),
            $map[$suratEditable->nomor_pengajuan]->edit_url
        );

        $this->assertTrue($map[$umkmEditable->nomor_pendaftaran]->editable);
        $this->assertSame(
            route('pendaftaran-umkm.edit', $umkmEditable->pendaftaran_umkm_id),
            $map[$umkmEditable->nomor_pendaftaran]->edit_url
        );

        // Pengajuan yang sudah selesai → editable false
        $this->assertFalse($map[$suratDiproses->nomor_pengajuan]->editable);
    }
}
