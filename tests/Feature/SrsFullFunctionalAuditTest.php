<?php

namespace Tests\Feature;

use App\Models\AcaraModel;
use App\Models\BeritaModel;
use App\Models\BudayaModel;
use App\Models\GaleriModel;
use App\Models\JenisSuratModel;
use App\Models\PendaftaranUmkmModel;
use App\Models\PengaduanModel;
use App\Models\PengajuanSuratModel;
use App\Models\PertanyaanUmumModel;
use App\Models\RiwayatPengajuanSuratModel;
use App\Models\StrukturDesaModel;
use App\Models\UMKMModel;
use App\Models\UserModel;
use App\Models\WisataModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SrsFullFunctionalAuditTest extends TestCase
{
    use DatabaseTransactions;

    protected UserModel $staff;
    protected UserModel $kasi;
    protected UserModel $sekdes;
    protected UserModel $kades;
    protected UserModel $masyarakat;
    protected UserModel $masyarakatLain;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->staff = UserModel::create([
            'name'     => 'Staff Audit',
            'email'    => 'staff_audit_' . uniqid() . '@jambelaer.desa.id',
            'password' => Hash::make('password123'),
            'role'     => UserModel::ROLE_STAFF_DESA,
            'jabatan'  => 'Staff Pelayanan',
        ]);

        $this->kasi = UserModel::create([
            'name'     => 'Kasi Audit',
            'email'    => 'kasi_audit_' . uniqid() . '@jambelaer.desa.id',
            'password' => Hash::make('password123'),
            'role'     => UserModel::ROLE_KASI_PEMERINTAHAN,
            'jabatan'  => 'Kasi Pemerintahan',
        ]);

        $this->sekdes = UserModel::create([
            'name'     => 'Sekdes Audit',
            'email'    => 'sekdes_audit_' . uniqid() . '@jambelaer.desa.id',
            'password' => Hash::make('password123'),
            'role'     => UserModel::ROLE_SEKRETARIS_DESA,
            'jabatan'  => 'Sekretaris Desa',
        ]);

        $this->kades = UserModel::create([
            'name'     => 'Kades Audit',
            'email'    => 'kades_audit_' . uniqid() . '@jambelaer.desa.id',
            'password' => Hash::make('password123'),
            'role'     => UserModel::ROLE_KEPALA_DESA,
            'jabatan'  => 'Kepala Desa',
        ]);

        $this->masyarakat = UserModel::create([
            'name'     => 'Warga Audit Utama',
            'email'    => 'warga_audit_' . uniqid() . '@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => UserModel::ROLE_MASYARAKAT,
        ]);

        $this->masyarakatLain = UserModel::create([
            'name'     => 'Warga Audit Kedua',
            'email'    => 'warga2_audit_' . uniqid() . '@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => UserModel::ROLE_MASYARAKAT,
        ]);
    }

    /**
     * SRS-F-001: Autentikasi Login Pengguna & Perangkat Desa
     */
    public function test_srs_f_001_login_authentication(): void
    {
        // 1. Login Masyarakat via form publik
        $resWarga = $this->post('/login', [
            'email'    => $this->masyarakat->email,
            'password' => 'password123',
        ]);
        $resWarga->assertRedirect('/pengajuan-saya');
        $this->assertAuthenticatedAs($this->masyarakat);

        // 2. Login Perangkat Desa via halaman login terpadu
        $this->post('/logout');
        $resAdmin = $this->post('/login', [
            'email'    => $this->staff->email,
            'password' => 'password123',
        ]);
        $resAdmin->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->staff);

        // 3. Password salah ditolak
        $this->post('/logout');
        $resSalah = $this->post('/login', [
            'email'    => $this->staff->email,
            'password' => 'passwordsalah',
        ]);
        $resSalah->assertSessionHasErrors('email');
    }

    /**
     * SRS-F-002: Kelola Profil Desa (Staff Desa, Kepala Desa) & Direct URL Rejection
     */
    public function test_srs_f_002_kelola_profil_desa(): void
    {
        // Staff Desa & Kades berhak akses
        $this->actingAs($this->staff)->get('/admin/profil-desa')->assertStatus(200);
        $this->actingAs($this->kades)->get('/admin/profil-desa')->assertStatus(200);

        // Kasi Pemerintahan & Sekdes ditolak (HTTP 403)
        $this->actingAs($this->kasi)->get('/admin/profil-desa')->assertStatus(403);
        $this->actingAs($this->sekdes)->get('/admin/profil-desa')->assertStatus(403);

        // Update konten sejarah
        $resUpdate = $this->actingAs($this->staff)->put('/admin/tentang-desa/sejarah', [
            'desa_sejarah' => 'Sejarah Desa Jambelaer terbarukan untuk uji audit SRS.',
        ]);
        $resUpdate->assertRedirect();
    }

    /**
     * SRS-F-002.1: Lihat Profil Desa (Masyarakat tanpa login)
     */
    public function test_srs_f_002_1_lihat_profil_desa_publik(): void
    {
        $response = $this->get('/profil-desa');
        $response->assertStatus(200);
        $response->assertSee('Desa Jambelaer');
    }

    /**
     * SRS-F-003: Kelola Struktur Desa (Staff Desa, Kepala Desa) & Direct URL Rejection
     */
    public function test_srs_f_003_kelola_struktur_desa(): void
    {
        $this->actingAs($this->staff)->get('/admin/struktur')->assertStatus(200);
        $this->actingAs($this->kasi)->get('/admin/struktur')->assertStatus(403);
        $this->actingAs($this->sekdes)->get('/admin/struktur')->assertStatus(403);

        $foto = UploadedFile::fake()->create('kades.jpg', 150, 'image/jpeg');
        $resStore = $this->actingAs($this->staff)->post('/admin/struktur', [
            'nama'    => 'Deden Suhendar',
            'jabatan' => 'Kepala Desa',
            'foto'    => $foto,
            'urutan'  => 1,
        ]);
        $resStore->assertRedirect();
    }

    /**
     * SRS-F-003.1: Lihat Data Struktur Desa (Masyarakat tanpa login)
     */
    public function test_srs_f_003_1_lihat_struktur_desa_publik(): void
    {
        $response = $this->get('/struktur-desa');
        $response->assertStatus(200);
    }

    /**
     * SRS-F-004: Kelola Data Berita (Staff Desa, Kasi Pemerintahan)
     */
    public function test_srs_f_004_kelola_data_berita(): void
    {
        // Staff Desa akses semua berita
        $this->actingAs($this->staff)->get('/admin/berita')->assertStatus(200);

        // Kasi Pemerintahan akses berita yang disaring
        $this->actingAs($this->kasi)->get('/admin/berita')->assertStatus(200);

        // Kasi Pemerintahan mencoba input kategori 'umum' -> DITOLAK validasi
        $resUmum = $this->actingAs($this->kasi)->post('/admin/berita', [
            'judul'    => 'Berita Umum Ilegal Kasi',
            'kategori' => 'umum',
            'penulis'  => 'Kasi',
            'konten'   => 'Konten',
        ]);
        $resUmum->assertSessionHasErrors('kategori');

        // Kasi Pemerintahan input kategori kegiatan_pemerintahan -> BERHASIL
        $resPem = $this->actingAs($this->kasi)->post('/admin/berita', [
            'judul'        => 'Musrenbang Desa Jambelaer ' . uniqid(),
            'kategori'     => 'kegiatan_pemerintahan',
            'penulis'      => 'Kasi Pem',
            'konten'       => 'Pemerintah desa menggelar musyawarah perencanaan pembangunan.',
            'is_published' => 1,
        ]);
        $resPem->assertRedirect(route('admin.berita.index'));

        // Sekdes ditolak akses berita
        $this->actingAs($this->sekdes)->get('/admin/berita')->assertStatus(403);
    }

    /**
     * SRS-F-004.1: Lihat Data Berita (Masyarakat tanpa login)
     */
    public function test_srs_f_004_1_lihat_data_berita_publik(): void
    {
        $this->get('/berita')->assertStatus(200);
        $berita = BeritaModel::where('is_published', true)->first();
        if ($berita) {
            $this->get('/berita/' . $berita->slug)->assertStatus(200);
        }
    }

    /**
     * SRS-F-005: Kelola Data UMKM (Staff Desa, Kepala Desa)
     */
    public function test_srs_f_005_kelola_data_umkm(): void
    {
        $this->actingAs($this->staff)->get('/admin/produk')->assertStatus(200);
        $this->actingAs($this->kasi)->get('/admin/produk')->assertStatus(403);
        $this->actingAs($this->sekdes)->get('/admin/produk')->assertStatus(403);
    }

    /**
     * SRS-F-005.1: Lihat Data UMKM & Tautan WhatsApp Aktif format https://wa.me/
     */
    public function test_srs_f_005_1_lihat_data_umkm_dan_whatsapp(): void
    {
        $this->get('/umkm')->assertStatus(200);

        $umkm = UMKMModel::first();
        if ($umkm) {
            $res = $this->get('/umkm/' . $umkm->slug);
            $res->assertStatus(200);
            if ($umkm->no_whatsapp_umkm) {
                $res->assertSee('https://wa.me/', false);
            }
        }
    }

    /**
     * SRS-F-006 & SRS-F-006.1: Wisata
     */
    public function test_srs_f_006_kelola_dan_lihat_wisata(): void
    {
        $this->actingAs($this->staff)->get('/admin/wisata')->assertStatus(200);
        $this->actingAs($this->kasi)->get('/admin/wisata')->assertStatus(403);
        $this->get('/wisata')->assertStatus(200);
    }

    /**
     * SRS-F-007 & SRS-F-007.1: Budaya
     */
    public function test_srs_f_007_kelola_dan_lihat_budaya(): void
    {
        $this->actingAs($this->staff)->get('/admin/budaya')->assertStatus(200);
        $this->actingAs($this->sekdes)->get('/admin/budaya')->assertStatus(403);
        $this->get('/budaya')->assertStatus(200);
    }

    /**
     * SRS-F-008 & SRS-F-008.1: Galeri
     */
    public function test_srs_f_008_kelola_dan_lihat_galeri(): void
    {
        $this->actingAs($this->staff)->get('/admin/galeri')->assertStatus(200);
        $this->actingAs($this->kasi)->get('/admin/galeri')->assertStatus(403);
        $this->get('/galeri')->assertStatus(200);
    }

    /**
     * SRS-F-009 & SRS-F-009.1: Agenda Acara
     */
    public function test_srs_f_009_kelola_dan_lihat_agenda_acara(): void
    {
        $this->actingAs($this->staff)->get('/admin/acara')->assertStatus(200);
        $this->actingAs($this->sekdes)->get('/admin/acara')->assertStatus(403);
        $this->get('/acara')->assertStatus(200);
    }

    /**
     * SRS-F-010 & SRS-F-010.1: Alur Pengajuan Pembuatan Surat Berjenjang & Log Riwayat
     */
    public function test_srs_f_010_alur_pengajuan_surat_berjenjang(): void
    {
        $jenisSurat = JenisSuratModel::first() ?: JenisSuratModel::create([
            'nama_surat' => 'Surat Keterangan Usaha',
            'kode_surat' => 'SKU',
            'is_active'  => true,
        ]);

        // 1. Masyarakat mengajukan permohonan surat (SRS-F-010.1)
        $fileKtp = UploadedFile::fake()->create('ktp.jpg', 150, 'image/jpeg');
        $fileKk  = UploadedFile::fake()->create('kk.jpg', 150, 'image/jpeg');

        $resAjukan = $this->actingAs($this->masyarakat)->post('/pengajuan-surat', [
            'jenis_surat_id' => $jenisSurat->id,
            'name'           => $this->masyarakat->name,
            'nik'            => '3213010101010001',
            'no_kk'          => '3213010101010002',
            'no_whatsapp'    => '081298765432',
            'alamat_pemohon' => 'Dusun Jambelaer 1',
            'keperluan'      => 'Pengajuan Pinjaman Modal Usaha',
            'file_ktp'       => $fileKtp,
            'file_kk'        => $fileKk,
        ]);
        $resAjukan->assertRedirect();

        $surat = PengajuanSuratModel::where('user_id', $this->masyarakat->user_id)->latest()->first();
        $this->assertNotNull($surat);
        $this->assertEquals('diajukan', $surat->status);

        // 2. Kasi Pem mencoba akses pengajuan surat -> DITOLAK (HTTP 403)
        $this->actingAs($this->kasi)->get('/admin/pengajuan-surat')->assertStatus(403);

        // 3. Staff Desa mencoba langsung menyelesaikan surat tanpa verifikasi Sekdes -> DITOLAK (HTTP 403)
        $this->actingAs($this->staff)->patch('/admin/pengajuan-surat/' . $surat->pengajuan_surat_id . '/status', [
            'status' => 'selesai',
        ])->assertStatus(403);

        // 4. Tahap 1: Staff Desa memeriksa berkas -> status: diproses
        $resStaff = $this->actingAs($this->staff)->patch('/admin/pengajuan-surat/' . $surat->pengajuan_surat_id . '/status', [
            'status'        => 'diproses',
            'catatan_admin' => 'Berkas persyaratan KTP & KK lengkap dan valid.',
        ]);
        $resStaff->assertRedirect();
        $surat->refresh();
        $this->assertEquals('diproses', $surat->status);
        $this->assertEquals($this->staff->user_id, $surat->diproses_by);

        // 5. Kepala Desa mencoba menyetujui padahal belum diverifikasi Sekdes -> GAGAL (Redirect error)
        $resKadesPremature = $this->actingAs($this->kades)->patch('/admin/pengajuan-surat/' . $surat->pengajuan_surat_id . '/status', [
            'status' => 'selesai',
        ]);
        $resKadesPremature->assertSessionHas('error');

        // 6. Tahap 2: Sekretaris Desa memverifikasi surat -> status: diverifikasi
        $resSekdes = $this->actingAs($this->sekdes)->patch('/admin/pengajuan-surat/' . $surat->pengajuan_surat_id . '/status', [
            'status'        => 'diverifikasi',
            'catatan_admin' => 'Telah diverifikasi sesuai basis data kependudukan.',
        ]);
        $resSekdes->assertRedirect();
        $surat->refresh();
        $this->assertEquals('diverifikasi', $surat->status);
        $this->assertEquals($this->sekdes->user_id, $surat->diverifikasi_by);

        // 7. Tahap 3: Kepala Desa memberikan persetujuan akhir -> status: selesai
        $resKades = $this->actingAs($this->kades)->patch('/admin/pengajuan-surat/' . $surat->pengajuan_surat_id . '/status', [
            'status'        => 'selesai',
            'catatan_admin' => 'Surat telah ditandatangani dan siap diterbitkan.',
        ]);
        $resKades->assertRedirect();
        $surat->refresh();
        $this->assertEquals('selesai', $surat->status);
        $this->assertEquals($this->kades->user_id, $surat->disetujui_by);

        // 8. Verifikasi pencatatan jejak audit riwayat_pengajuan_surats
        $riwayats = RiwayatPengajuanSuratModel::where('pengajuan_surat_id', $surat->pengajuan_surat_id)->orderBy('id')->get();
        $this->assertCount(3, $riwayats);
        $this->assertEquals('diproses', $riwayats[0]->status_baru);
        $this->assertEquals('diverifikasi', $riwayats[1]->status_baru);
        $this->assertEquals('selesai', $riwayats[2]->status_baru);

        // 9. Uji pembatalan pengajuan oleh masyarakat pada pengajuan baru (SRS-F-010.1)
        $suratBaru = PengajuanSuratModel::create([
            'jenis_surat_id'  => $jenisSurat->id,
            'user_id'         => $this->masyarakat->user_id,
            'nomor_pengajuan' => 'BATAL-' . uniqid(),
            'nama_pemohon'    => $this->masyarakat->name,
            'nik'             => '3213010101010099',
            'no_kk'           => '3213010101010098',
            'alamat_pemohon'  => 'Dusun Jambelaer 2',
            'keperluan'       => 'Pengajuan uji pembatalan mandiri',
            'status'          => 'diajukan',
        ]);
        $this->actingAs($this->masyarakat)->post('/pengajuan-surat/' . $suratBaru->pengajuan_surat_id . '/batal')->assertRedirect();
        $suratBaru->refresh();
        $this->assertEquals('dibatalkan', $suratBaru->status);
    }

    /**
     * SRS-F-011 & SRS-F-011.1: Pengaduan Masyarakat
     */
    public function test_srs_f_011_pengaduan_masyarakat(): void
    {
        // 1. Masyarakat kirim pengaduan
        $resPengaduan = $this->actingAs($this->masyarakat)->post('/pengaduan', [
            'nama'          => $this->masyarakat->name,
            'no_whatsapp'   => '081233334444',
            'judul'         => 'Jalan Berlubang di RT 02',
            'lokasi'        => 'Dekat Pos Ronda RT 02',
            'isi_pengaduan' => 'Terdapat lubang jalan yang cukup dalam dan membahayakan pengendara.',
        ]);
        $resPengaduan->assertRedirect();

        $pengaduan = PengaduanModel::where('user_id', $this->masyarakat->user_id)->latest()->first();
        $this->assertNotNull($pengaduan);
        $this->assertEquals('diajukan', $pengaduan->status);

        // 2. Staff Desa menindaklanjuti dan memberi tanggapan
        $resTanggapan = $this->actingAs($this->staff)->patch('/admin/pengaduan/' . $pengaduan->pengaduan_id . '/status', [
            'status'          => 'diproses',
            'tanggapan_admin' => 'Laporan telah diteruskan ke tim pemeliharaan jalan.',
        ]);
        $resTanggapan->assertRedirect();
        $pengaduan->refresh();
        $this->assertEquals('diproses', $pengaduan->status);

        // 3. Sekdes dilarang akses pengaduan (HTTP 403)
        $this->actingAs($this->sekdes)->get('/admin/pengaduan')->assertStatus(403);
    }

    /**
     * SRS-F-012 & SRS-F-012.1: Pertanyaan Umum
     */
    public function test_srs_f_012_pertanyaan_umum(): void
    {
        // 1. Masyarakat kirim pertanyaan
        $resTanya = $this->actingAs($this->masyarakat)->post('/pertanyaan-umum', [
            'nama'        => $this->masyarakat->name,
            'no_whatsapp' => '081255556666',
            'subjek'      => 'Jadwal Pembuatan KTP Elektronik',
            'pertanyaan'  => 'Apakah hari Sabtu kantor desa melayani rekam e-KTP?',
        ]);
        $resTanya->assertRedirect();

        $tanya = PertanyaanUmumModel::where('user_id', $this->masyarakat->user_id)->latest()->first();
        $this->assertNotNull($tanya);

        // 2. Staff Desa menjawab pertanyaan
        $resJawab = $this->actingAs($this->staff)->patch('/admin/pertanyaan-umum/' . $tanya->pertanyaan_id . '/status', [
            'status'        => 'dijawab',
            'jawaban_admin' => 'Pelayanan administrasi kependudukan buka Senin s.d. Jumat pukul 08:00 - 15:30 WIB.',
        ]);
        $resJawab->assertRedirect();
        $tanya->refresh();
        $this->assertEquals('dijawab', $tanya->status);
    }

    /**
     * SRS-F-013 & SRS-F-013.1: Pendaftaran UMKM & Publikasi ke Katalog
     */
    public function test_srs_f_013_pendaftaran_umkm_dan_publikasi(): void
    {
        $foto = UploadedFile::fake()->create('opak_pedas.jpg', 200, 'image/jpeg');

        // 1. Pelaku usaha mendaftarkan UMKM
        $resDaftar = $this->actingAs($this->masyarakat)->post('/pendaftaran-umkm', [
            'nama_usaha'       => 'Opak Pedas Sari Rasa ' . uniqid(),
            'nama_pemilik'     => $this->masyarakat->name,
            'alamat_usaha'     => 'Dusun Cikondang RT 04 RW 02',
            'deskripsi_usaha'  => 'Olahan opak singkong rasa pedas khas Sunda.',
            'produk'           => 'Opak Singkong Pedas',
            'nomor_whatsapp'   => '081277778888',
            'foto_produk'      => $foto,
        ]);
        $resDaftar->assertRedirect();

        $pendaftaran = PendaftaranUmkmModel::where('user_id', $this->masyarakat->user_id)->latest()->first();
        $this->assertNotNull($pendaftaran);

        // 2. Staff Desa memverifikasi dan mempublikasikan ke katalog UMKM
        $resPublikasi = $this->actingAs($this->staff)->post('/admin/pendaftaran-umkm/' . $pendaftaran->pendaftaran_umkm_id . '/publikasikan');
        $resPublikasi->assertRedirect();

        $pendaftaran->refresh();
        $this->assertEquals('disetujui', $pendaftaran->status);

        // Pastikan produk tampil di tabel UMKM
        $produk = UMKMModel::where('pendaftaran_umkm_id', $pendaftaran->pendaftaran_umkm_id)->first();
        $this->assertNotNull($produk);
        $this->assertTrue($produk->is_active);
    }

    /**
     * SRS-F-014: Kelola Pengguna & Penetapan Role Perangkat Desa
     */
    public function test_srs_f_014_kelola_pengguna_dan_penetapan_role(): void
    {
        $this->actingAs($this->staff)->get('/admin/kelola-admin')->assertStatus(200);
        $this->actingAs($this->kades)->get('/admin/kelola-admin')->assertStatus(200);

        // Sekdes & Kasi dilarang kelola user (HTTP 403)
        $this->actingAs($this->sekdes)->get('/admin/kelola-admin')->assertStatus(403);
        $this->actingAs($this->kasi)->get('/admin/kelola-admin')->assertStatus(403);

        // Staff Desa membuat akun baru dengan role kasi_pemerintahan
        $newEmail = 'kasi_baru_' . uniqid() . '@jambelaer.desa.id';
        $resCreate = $this->actingAs($this->staff)->post('/admin/kelola-admin', [
            'name'                  => 'Kasi Pem Baru',
            'email'                 => $newEmail,
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => UserModel::ROLE_KASI_PEMERINTAHAN,
            'jabatan'               => 'Kasi Pemerintahan Desa',
        ]);
        $resCreate->assertRedirect(route('admin.kelola-admin.index'));

        $createdUser = UserModel::where('email', $newEmail)->first();
        $this->assertNotNull($createdUser);
        $this->assertEquals(UserModel::ROLE_KASI_PEMERINTAHAN, $createdUser->role);
        $this->assertEquals('Kasi Pemerintahan Desa', $createdUser->jabatan);
    }

    /**
     * SRS-F-015: Logout Sesi Pengguna
     */
    public function test_srs_f_015_logout_session(): void
    {
        // 1. Logout Masyarakat — diarahkan ke halaman login (/login)
        $this->actingAs($this->masyarakat)->post('/logout')->assertRedirect(route('login'));
        $this->assertGuest();

        // 2. Logout Admin — diarahkan ke halaman login (/login)
        $this->actingAs($this->staff)->post('/logout')->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /**
     * SRS-F-016: Registrasi Akun Masyarakat
     */
    public function test_srs_f_016_registrasi_masyarakat(): void
    {
        $regEmail = 'warga_reg_' . uniqid() . '@jambelaer.desa.id';
        $resReg = $this->post('/register', [
            'name'                  => 'Warga Baru Terdaftar',
            'email'                 => $regEmail,
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $resReg->assertRedirect(route('pengajuan.saya'));

        $wargaBaru = UserModel::where('email', $regEmail)->first();
        $this->assertNotNull($wargaBaru);
        $this->assertEquals(UserModel::ROLE_MASYARAKAT, $wargaBaru->role);
        $this->assertTrue($wargaBaru->isMasyarakat());
    }
}
