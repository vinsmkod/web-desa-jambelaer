<?php

namespace Tests\Feature;

use App\Models\JenisSurat;
use App\Models\Pengaduan;
use App\Models\PengajuanSurat;
use App\Models\PertanyaanUmum;
use App\Models\PendaftaranUmkm;
use App\Models\UMKM;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LayananMasyarakatFlowTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * 1. Public information pages must be accessible with HTTP 200 without authentication.
     */
    public function test_public_pages_accessible_without_login(): void
    {
        $publicRoutes = [
            '/',
            '/tentang-kami',
            '/umkm',
            '/budaya',
            '/wisata',
            '/galeri',
            '/acara',
            '/berita',
            '/kontak',
        ];

        foreach ($publicRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    /**
     * 2. Protected citizen routes and actions require authentication.
     */
    public function test_guest_cannot_access_pengajuan_saya_or_submit_service(): void
    {
        // Accessing tracking as guest redirects to login
        $response = $this->get('/pengajuan-saya');
        $response->assertRedirect('/login');

        // Submitting services as guest redirects to login
        $suratResponse = $this->post('/pengajuan-surat', []);
        $suratResponse->assertRedirect('/login');

        $pengaduanResponse = $this->post('/pengaduan', []);
        $pengaduanResponse->assertRedirect('/login');

        $pertanyaanResponse = $this->post('/pertanyaan-umum', []);
        $pertanyaanResponse->assertRedirect('/login');

        $umkmResponse = $this->post('/pendaftaran-umkm', []);
        $umkmResponse->assertRedirect('/login');
    }

    /**
     * 3. Citizen registration and role assignment.
     */
    public function test_citizen_registration_creates_masyarakat_role(): User
    {
        $email = 'warga_' . uniqid() . '@jambelaer.desa.id';
        $response = $this->post('/register', [
            'name'                  => 'Budi Warga Jambelaer',
            'email'                 => $email,
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('pengajuan.saya'));

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals('masyarakat', $user->role);
        $this->assertTrue($user->isMasyarakat());
        $this->assertFalse($user->isAdmin());

        return $user;
    }

    /**
     * 4. Citizen can submit 4 separated services and they are stored in their respective tables.
     */
    public function test_authenticated_citizen_submits_all_four_services(): void
    {
        Storage::fake('public');

        $user = User::create([
            'name'     => 'Siti Rahma',
            'email'    => 'siti_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'masyarakat',
        ]);

        // 4a. Service 1: Pengajuan Surat
        $jenisSurat = JenisSurat::first() ?: JenisSurat::create([
            'nama_surat' => 'Surat Keterangan Domisili',
            'kode_surat' => 'SKD',
            'is_active'  => true,
        ]);

        $fileKtp = UploadedFile::fake()->create('ktp.jpg', 200, 'image/jpeg');
        $fileKk = UploadedFile::fake()->create('kk.jpg', 200, 'image/jpeg');

        $resSurat = $this->actingAs($user)->post('/pengajuan-surat', [
            'jenis_surat_id' => $jenisSurat->id,
            'name'           => 'Siti Rahma',
            'nik'            => '3213012345678901',
            'no_kk'          => '3213012345678902',
            'no_whatsapp'    => '081234567891',
            'alamat_pemohon' => 'Dusun Jambelaer RT 01 RW 01',
            'keperluan'      => 'Persyaratan administrasi perbankan',
            'file_ktp'       => $fileKtp,
            'file_kk'        => $fileKk,
        ]);

        $resSurat->assertSessionHasNoErrors();
        $resSurat->assertRedirect();
        $surat = PengajuanSurat::where('user_id', $user->user_id)->latest()->first();
        $this->assertNotNull($surat);
        $this->assertEquals('diajukan', $surat->status);
        $this->assertNotNull($surat->file_ktp);
        $this->assertNotNull($surat->file_kk);

        // 4b. Service 2: Pengaduan Masyarakat
        $fotoBukti = UploadedFile::fake()->create('bukti_jalan_rusak.jpg', 200, 'image/jpeg');
        $resPengaduan = $this->actingAs($user)->post('/pengaduan', [
            'nama'          => $user->name,
            'no_whatsapp'   => '081234567891',
            'judul'         => 'Lampu Jalan Padam di RW 03',
            'lokasi'        => 'Perempatan RW 03',
            'isi_pengaduan' => 'Lampu penerangan jalan umum padam sejak 3 hari lalu.',
            'foto_bukti'    => $fotoBukti,
        ]);

        $resPengaduan->assertSessionHasNoErrors();
        $resPengaduan->assertRedirect();
        $pengaduan = Pengaduan::where('user_id', $user->user_id)->latest()->first();
        $this->assertNotNull($pengaduan);
        $this->assertEquals('diajukan', $pengaduan->status);
        $this->assertNotNull($pengaduan->foto_bukti);

        // 4c. Service 3: Pertanyaan Umum
        $resPertanyaan = $this->actingAs($user)->post('/pertanyaan-umum', [
            'nama'        => $user->name,
            'no_whatsapp' => '081234567891',
            'subjek'      => 'Pertanyaan Jadwal Pelayanan',
            'pertanyaan'  => 'Berapa jam operasional kantor desa di hari Jumat?',
        ]);

        $resPertanyaan->assertSessionHasNoErrors();
        $resPertanyaan->assertRedirect();
        $pertanyaan = PertanyaanUmum::where('user_id', $user->user_id)->latest()->first();
        $this->assertNotNull($pertanyaan);
        $this->assertEquals('diajukan', $pertanyaan->status);

        // 4d. Service 4: Pendaftaran UMKM
        $fotoProduk = UploadedFile::fake()->create('keripik_singkong.jpg', 200, 'image/jpeg');
        $resUmkm = $this->actingAs($user)->post('/pendaftaran-umkm', [
            'nama_usaha'        => 'Keripik Renyah Cikadu',
            'nama_pemilik'      => $user->name,
            'nomor_whatsapp'    => '081234567891',
            'instagram'         => '@keripikcikadu',
            'alamat_usaha'      => 'Dusun Cikadu RT 02 RW 01',
            'produk'            => 'Keripik Singkong',
            'deskripsi_usaha'   => 'Camilan olahan singkong asli kebun Desa Jambelaer.',
            'nib'               => '1234567890123',
            'sertifikasi_halal' => 'ID3211000123456',
            'foto_produk'       => $fotoProduk,
        ]);

        $resUmkm->assertSessionHasNoErrors();
        $resUmkm->assertRedirect();
        $umkm = PendaftaranUmkm::where('user_id', $user->user_id)->latest()->first();
        $this->assertNotNull($umkm);
        $this->assertEquals('diajukan', $umkm->status);
        $this->assertNotNull($umkm->foto_produk);

        // 4e. Citizen can view all submissions in /pengajuan-saya
        $listResponse = $this->actingAs($user)->get('/pengajuan-saya');
        $listResponse->assertStatus(200);
        $listResponse->assertSee($surat->nomor_pengajuan);
        $listResponse->assertSee($pengaduan->nomor_pengaduan);
        $listResponse->assertSee($pertanyaan->nomor_pertanyaan);
        $listResponse->assertSee($umkm->nomor_pendaftaran);
    }

    /**
     * 5. Strict IDOR Authorization: Citizen B cannot view Citizen A's submission.
     */
    public function test_citizen_cannot_view_other_citizens_submission(): void
    {
        $userA = User::create([
            'name'     => 'Warga A',
            'email'    => 'wargaa_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'masyarakat',
        ]);

        $userB = User::create([
            'name'     => 'Warga B',
            'email'    => 'wargab_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'masyarakat',
        ]);

        $pengaduanA = Pengaduan::create([
            'user_id'         => $userA->user_id,
            'nomor_pengaduan' => Pengaduan::generateNomorPengaduan(),
            'nama'            => $userA->name,
            'no_whatsapp'     => '081234567890',
            'judul'           => 'Rahasia Warga A',
            'isi_pengaduan'   => 'Isi laporan privasi Warga A',
            'status'          => 'diajukan',
        ]);

        // User A can view own submission
        $ownResponse = $this->actingAs($userA)->get("/pengajuan-saya/pengaduan/{$pengaduanA->pengaduan_id}");
        $ownResponse->assertStatus(200);
        $ownResponse->assertSee($pengaduanA->nomor_pengaduan);

        // User B CANNOT view User A's submission -> 403 Forbidden
        $otherResponse = $this->actingAs($userB)->get("/pengajuan-saya/pengaduan/{$pengaduanA->pengaduan_id}");
        $otherResponse->assertStatus(403);
    }

    /**
     * 6. Citizen cannot access admin area (403 Forbidden).
     */
    public function test_citizen_cannot_access_admin_dashboard(): void
    {
        $citizen = User::create([
            'name'     => 'Warga Biasa',
            'email'    => 'warga_biasa_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'masyarakat',
        ]);

        $response = $this->actingAs($citizen)->get('/admin');
        $response->assertStatus(403);
    }

    /**
     * 6b. Admin can access admin dashboard with 200 OK.
     */
    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::create([
            'name'     => 'Admin Dashboard Tester',
            'email'    => 'admin_dash_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Layanan Warga Terbaru');

        // Test all 4 separated admin management pages + jenis surat
        $this->actingAs($admin)->get('/admin/pengajuan-surat')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/pengaduan')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/pertanyaan-umum')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/pendaftaran-umkm')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/jenis-surat')->assertStatus(200);
    }

    /**
     * 6c. Citizen can access all 4 service form pages and legacy tracking redirect works.
     */
    public function test_citizen_can_access_all_four_service_form_pages_and_legacy_tracking(): void
    {
        $citizen = User::create([
            'name'     => 'Warga Form Tester',
            'email'    => 'warga_form_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'masyarakat',
        ]);

        $this->actingAs($citizen)->get('/pengajuan-surat')->assertStatus(200);
        $this->actingAs($citizen)->get('/pengaduan')->assertStatus(200);
        $this->actingAs($citizen)->get('/pertanyaan-umum')->assertStatus(200);
        $this->actingAs($citizen)->get('/pendaftaran-umkm')->assertStatus(200);

        // Test legacy /pengajuan-saya/{id} redirect
        $legacyRes = $this->actingAs($citizen)->get('/pengajuan-saya/123');
        $legacyRes->assertRedirect(route('pengajuan.saya'));
    }

    /**
     * 7. Admin can process submission, update status, and citizen sees update on tracking.
     */
    public function test_admin_processes_submission_and_citizen_sees_update_on_website(): void
    {
        $admin = User::create([
            'name'     => 'Admin Desa',
            'email'    => 'admin_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);

        $citizen = User::create([
            'name'     => 'Deden Permana',
            'email'    => 'deden_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'masyarakat',
        ]);

        $pengaduan = Pengaduan::create([
            'user_id'         => $citizen->user_id,
            'nomor_pengaduan' => Pengaduan::generateNomorPengaduan(),
            'nama'            => $citizen->name,
            'no_whatsapp'     => '081234567899',
            'judul'           => 'Saluran Air Tersumbat di RT 05',
            'isi_pengaduan'   => 'Saluran air tersumbat sampah saat hujan lebat menyebabkan genangan.',
            'status'          => 'diajukan',
        ]);

        // Step 1: Citizen views initial tracking (Status: Diajukan)
        $trackRes1 = $this->actingAs($citizen)->get("/pengajuan-saya/pengaduan/{$pengaduan->pengaduan_id}");
        $trackRes1->assertStatus(200);
        $trackRes1->assertSee('Diajukan');

        // Step 2: Admin reviews submission and updates to "diproses" with note
        $adminUpdateRes = $this->actingAs($admin)->patch("/admin/pengaduan/{$pengaduan->pengaduan_id}/status", [
            'status'          => 'diproses',
            'tanggapan_admin' => 'Laporan telah dikoordinasikan dengan tim kebersihan RT 05.',
        ]);
        $adminUpdateRes->assertRedirect();

        // Check DB
        $pengaduan->refresh();
        $this->assertEquals('diproses', $pengaduan->status);
        $this->assertEquals('Laporan telah dikoordinasikan dengan tim kebersihan RT 05.', $pengaduan->tanggapan_admin);

        // Step 3: Citizen views tracking on website - sees "Diproses" and admin's note
        $trackRes2 = $this->actingAs($citizen)->get("/pengajuan-saya/pengaduan/{$pengaduan->pengaduan_id}");
        $trackRes2->assertStatus(200);
        $trackRes2->assertSee('Diproses');
        $trackRes2->assertSee('Laporan telah dikoordinasikan dengan tim kebersihan RT 05.');

        // Step 4: Admin marks as "selesai" with final note
        $this->actingAs($admin)->patch("/admin/pengaduan/{$pengaduan->pengaduan_id}/status", [
            'status'          => 'selesai',
            'tanggapan_admin' => 'Saluran air telah selesai dibersihkan oleh warga bersama petugas.',
        ]);

        // Step 5: Citizen sees "Selesai" on website
        $trackRes3 = $this->actingAs($citizen)->get("/pengajuan-saya/pengaduan/{$pengaduan->pengaduan_id}");
        $trackRes3->assertStatus(200);
        $trackRes3->assertSee('Selesai');
        $trackRes3->assertSee('Saluran air telah selesai dibersihkan');
    }

    /**
     * 8. UMKM Approval and Publication Flow:
     *    Pendaftaran UMKM -> Verifikasi Admin -> Disetujui -> Publikasi -> Produk -> Tampil ke publik
     */
    public function test_umkm_approval_and_publication_creates_product(): void
    {
        $admin = User::create([
            'name'     => 'Admin Desa',
            'email'    => 'admin_umkm_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);

        $citizen = User::create([
            'name'     => 'Pengusaha Madu',
            'email'    => 'madu_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'masyarakat',
        ]);

        $umkm = PendaftaranUmkm::create([
            'user_id'            => $citizen->user_id,
            'nomor_pendaftaran'  => PendaftaranUmkm::generateNomorPendaftaran(),
            'nama_usaha'         => 'Madu Hutan Jambelaer',
            'nama_pemilik'       => 'Pak Kosasih',
            'nomor_whatsapp'     => '081298765432',
            'alamat_usaha'       => 'Dusun 3 Jambelaer',
            'produk'             => 'Madu Murni Alami',
            'deskripsi_usaha'    => 'Madu murni hasil panen lebah hutan liar Jambelaer tanpa pengawet.',
            'nib'                => '9988776655443',
            'sertifikasi_halal'  => 'HALAL-12345',
            'foto_produk'        => 'uploads/img/DESA_JAMBELAER.png',
            'status'             => 'diajukan',
        ]);

        // Admin publishes the UMKM registration directly to Produk catalog
        $response = $this->actingAs($admin)->post("/admin/pendaftaran-umkm/{$umkm->pendaftaran_umkm_id}/publikasikan", [
            'catatan_admin' => 'UMKM telah diverifikasi dan disetujui untuk katalog desa.'
        ]);
        $response->assertRedirect();

        // Check UMKM status updated to disetujui
        $umkm->refresh();
        $this->assertEquals('disetujui', $umkm->status);

        // Check Produk / UMKM created and linked via pendaftaran_umkm_id
        $produk = UMKM::where('pendaftaran_umkm_id', $umkm->pendaftaran_umkm_id)->first();
        $this->assertNotNull($produk);
        $this->assertEquals('Madu Hutan Jambelaer', $produk->title);
        $this->assertEquals('Pak Kosasih', $produk->producer);
        $this->assertTrue($produk->is_active);

        // Public can view the product page
        $publicRes = $this->get('/umkm/' . $produk->slug);
        $publicRes->assertStatus(200);
        $publicRes->assertSee('Madu Hutan Jambelaer');
    }

    /**
     * 9. Unified login form: Admin and Citizen use the same login form,
     * and are redirected appropriately based on their role.
     */
    public function test_unified_login_form_and_role_based_redirection(): void
    {
        $resLogin = $this->get('/login');
        $resLogin->assertStatus(200);
        $resLogin->assertSee('Portal Masuk Sistem', false);

        $resAdminLogin = $this->get('/admin/login');
        $resAdminLogin->assertStatus(200);

        $admin = User::create([
            'name'     => 'Administrator Desa',
            'email'    => 'admin_test_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);

        $citizen = User::create([
            'name'     => 'Warga Biasa',
            'email'    => 'citizen_test_' . uniqid() . '@jambelaer.desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'masyarakat',
        ]);

        // Citizen logs in -> redirected to pengajuan.saya
        $resCit1 = $this->post('/login', [
            'email'    => $citizen->email,
            'password' => 'password123',
        ]);
        $resCit1->assertRedirect(route('pengajuan.saya'));
        $this->assertAuthenticatedAs($citizen);
        $this->post('/logout');

        // Admin logs in -> redirected to admin.dashboard
        $resAdm1 = $this->post('/login', [
            'email'    => $admin->email,
            'password' => 'password123',
        ]);
        $resAdm1->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
        $this->post('/logout');
    }
}
