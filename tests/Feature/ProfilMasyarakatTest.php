<?php

namespace Tests\Feature;

use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfilMasyarakatTest extends TestCase
{
    use DatabaseTransactions;

    protected UserModel $masyarakat;
    protected UserModel $masyarakatLain;
    protected UserModel $staffDesa;
    protected UserModel $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->masyarakat = UserModel::create([
            'name'     => 'Warga Uji Coba',
            'email'    => 'warga.uji.' . uniqid() . '@jambelaer.desa.id',
            'password' => Hash::make('password123'),
            'role'     => UserModel::ROLE_MASYARAKAT,
            'no_hp'    => '081234567890',
            'alamat'   => 'Dusun I RT 01 RW 01 Desa Jambelaer',
        ]);

        $this->masyarakatLain = UserModel::create([
            'name'     => 'Warga Lain',
            'email'    => 'warga.lain.' . uniqid() . '@jambelaer.desa.id',
            'password' => Hash::make('password123'),
            'role'     => UserModel::ROLE_MASYARAKAT,
            'no_hp'    => '089876543210',
            'alamat'   => 'Dusun II RT 03 RW 02 Desa Jambelaer',
        ]);

        $this->staffDesa = UserModel::create([
            'name'     => 'Staff Desa Uji',
            'email'    => 'staff.uji.' . uniqid() . '@jambelaer.desa.id',
            'password' => Hash::make('password123'),
            'role'     => UserModel::ROLE_STAFF_DESA,
        ]);

        $this->admin = UserModel::create([
            'name'     => 'Admin Uji',
            'email'    => 'admin.uji.' . uniqid() . '@jambelaer.desa.id',
            'password' => Hash::make('password123'),
            'role'     => UserModel::ROLE_ADMIN,
        ]);
    }

    /**
     * 1. Tamu (guest) yang belum login tidak dapat mengakses halaman profil.
     */
    public function test_tamu_dialihkan_ke_halaman_login(): void
    {
        $response = $this->get(route('profil.edit'));
        $response->assertRedirect(route('login'));

        $putResponse = $this->put(route('profil.update'), [
            'name'   => 'Nama Baru',
            'no_hp'  => '081299998888',
            'alamat' => 'Alamat Baru',
        ]);
        $putResponse->assertRedirect(route('login'));
    }

    /**
     * 2. Masyarakat dapat membuka halaman profil dan melihat data lama secara otomatis.
     */
    public function test_masyarakat_dapat_melihat_halaman_profil_dengan_data_lama(): void
    {
        $response = $this->actingAs($this->masyarakat)->get(route('profil.edit'));

        $response->assertStatus(200);
        $response->assertSee('Profil Akun Saya');
        $response->assertSee('Warga Uji Coba');
        $response->assertSee('081234567890');
        $response->assertSee('Dusun I RT 01 RW 01 Desa Jambelaer');
    }

    /**
     * 3 & 4 & 5. Ketiga informasi dapat diperbarui, tersimpan ke database, dan langsung tampil setelah disimpan.
     */
    public function test_masyarakat_dapat_memperbarui_nama_nohp_dan_alamat(): void
    {
        $payload = [
            'name'   => 'Ahmad Suryana Perdana',
            'no_hp'  => '085211223344',
            'alamat' => 'Kampung Melong RT 02 RW 04, Desa Jambelaer, Kec. Dawuan',
        ];

        $response = $this->actingAs($this->masyarakat)
            ->put(route('profil.update'), $payload);

        $response->assertRedirect(route('profil.edit'));
        $response->assertSessionHas('success', 'Profil akun Anda berhasil diperbarui.');

        // Pastikan perubahan tersimpan ke database
        $this->assertDatabaseHas('users', [
            'user_id' => $this->masyarakat->user_id,
            'name'    => 'Ahmad Suryana Perdana',
            'no_hp'   => '085211223344',
            'alamat'  => 'Kampung Melong RT 02 RW 04, Desa Jambelaer, Kec. Dawuan',
        ]);

        // Informasi terbaru langsung tampil pada halaman profil
        $followResponse = $this->actingAs($this->masyarakat)->get(route('profil.edit'));
        $followResponse->assertStatus(200);
        $followResponse->assertSee('Ahmad Suryana Perdana');
        $followResponse->assertSee('085211223344');
        $followResponse->assertSee('Kampung Melong RT 02 RW 04, Desa Jambelaer, Kec. Dawuan');
    }

    /**
     * 6. Validasi berjalan ketika kolom wajib dikosongkan atau format tidak valid.
     */
    public function test_validasi_gagal_ketika_kolom_dikosongkan(): void
    {
        $response = $this->actingAs($this->masyarakat)
            ->put(route('profil.update'), [
                'name'   => '',
                'no_hp'  => '',
                'alamat' => '',
            ]);

        $response->assertSessionHasErrors(['name', 'no_hp', 'alamat']);
    }

    public function test_validasi_panjang_karakter_dan_format_nohp(): void
    {
        // Nama kurang dari 3 karakter
        $responseMin = $this->actingAs($this->masyarakat)
            ->put(route('profil.update'), [
                'name'   => 'Ab',
                'no_hp'  => '08123456789',
                'alamat' => 'Alamat Valid',
            ]);
        $responseMin->assertSessionHasErrors(['name']);

        // Format no_hp mengandung karakter tidak valid
        $responseHp = $this->actingAs($this->masyarakat)
            ->put(route('profil.update'), [
                'name'   => 'Nama Valid',
                'no_hp'  => 'NOMOR-BUKAN-ANGKA!@#$',
                'alamat' => 'Alamat Valid',
            ]);
        $responseHp->assertSessionHasErrors(['no_hp']);
    }

    /**
     * 7. Masyarakat tidak dapat mengubah akun pengguna lain atau kolom terlarang (role, email, password, dll).
     */
    public function test_keamanan_mencegah_perubahan_role_email_password_dan_idor(): void
    {
        $passwordSebelum = $this->masyarakat->password;
        $emailSebelum    = $this->masyarakat->email;

        // Mencoba inject user_id akun lain, role admin, email baru, password baru
        $maliciousPayload = [
            'user_id'       => $this->masyarakatLain->user_id,
            'role'          => UserModel::ROLE_ADMIN,
            'email'         => 'hacker@jambelaer.desa.id',
            'password'      => 'hacked123',
            'nik'           => '9999999999999999',
            'jenis_kelamin' => 'L',
            'rt'            => '99',
            'rw'            => '99',
            'name'          => 'Nama Yang Sah',
            'no_hp'         => '081234567890',
            'alamat'        => 'Alamat Yang Sah',
        ];

        $response = $this->actingAs($this->masyarakat)
            ->put(route('profil.update'), $maliciousPayload);

        $response->assertRedirect(route('profil.edit'));

        $this->masyarakat->refresh();
        $this->masyarakatLain->refresh();

        // Akun masyarakat yang login: role, email, password tetap aman tidak berubah
        $this->assertSame(UserModel::ROLE_MASYARAKAT, $this->masyarakat->role);
        $this->assertSame($emailSebelum, $this->masyarakat->email);
        $this->assertSame($passwordSebelum, $this->masyarakat->password);

        // Akun masyarakat lain tidak tersentuh sama sekali
        $this->assertSame('Warga Lain', $this->masyarakatLain->name);
        $this->assertSame('089876543210', $this->masyarakatLain->no_hp);
    }

    /**
     * 8. Perangkat desa dan admin dibatasi dari fitur profil masyarakat.
     */
    public function test_perangkat_desa_dan_admin_tidak_dapat_mengakses_fitur_profil_masyarakat(): void
    {
        // Admin
        $responseAdmin = $this->actingAs($this->admin)->get(route('profil.edit'));
        $responseAdmin->assertStatus(403);

        $responseAdminPut = $this->actingAs($this->admin)->put(route('profil.update'), [
            'name'   => 'Admin Ubah',
            'no_hp'  => '081234567890',
            'alamat' => 'Kantor Desa',
        ]);
        $responseAdminPut->assertStatus(403);

        // Staff Desa
        $responseStaff = $this->actingAs($this->staffDesa)->get(route('profil.edit'));
        $responseStaff->assertStatus(403);
    }
}

