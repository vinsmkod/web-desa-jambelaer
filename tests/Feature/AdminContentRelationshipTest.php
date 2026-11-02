<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Budaya;
use App\Models\Galeri;
use App\Models\AgendaAcara;
use App\Models\PendaftaranUmkm;
use App\Models\UMKM;
use App\Models\StrukturDesa;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\CreatesApplication;

class AdminContentRelationshipTest extends \Tests\TestCase
{
    use DatabaseTransactions;
    public function test_user_content_relationships_and_foreign_keys(): void
    {
        // 1. Create a test admin user
        $user = User::create([
            'name'     => 'Test Admin Unit',
            'email'    => 'testadmin_' . uniqid() . '@jambelaer.id',
            'password' => bcrypt('password123'),
        ]);

        $this->assertNotNull($user->user_id);

        // 2. Test Berita relationship
        $berita = Berita::create([
            'created_by'   => $user->user_id,
            'judul'        => 'Test Judul Berita ' . uniqid(),
            'slug'         => 'test-slug-berita-' . uniqid(),
            'penulis'      => 'Test Admin Unit',
            'ringkasan'    => 'Test ringkasan berita',
            'konten'       => 'Test konten berita lengkap',
            'is_published' => true,
        ]);

        $this->assertEquals($user->user_id, $berita->created_by);
        $this->assertInstanceOf(User::class, $berita->user);
        $this->assertEquals($user->user_id, $berita->user->user_id);
        $this->assertTrue($user->berita->contains('berita_id', $berita->berita_id));

        // 3. Test Budaya relationship
        $budaya = Budaya::create([
            'created_by' => $user->user_id,
            'kategori'   => 'Tradisi',
            'title'      => 'Test Budaya ' . uniqid(),
            'excerpt'    => 'Test excerpt',
            'desc'       => 'Test desc',
            'urutan'     => 1,
        ]);

        $this->assertEquals($user->user_id, $budaya->created_by);
        $this->assertInstanceOf(User::class, $budaya->user);
        $this->assertEquals($user->user_id, $budaya->user->user_id);
        $this->assertTrue($user->budaya->contains('budaya_id', $budaya->budaya_id));

        // 4. Test Wisata relationship
        $wisata = \App\Models\Wisata::create([
            'created_by'      => $user->user_id,
            'nama'            => 'Test Wisata ' . uniqid(),
            'slug'            => 'test-wisata-' . uniqid(),
            'kategori'        => 'alam',
            'ringkasan'       => 'Test ringkasan wisata',
            'deskripsi'       => 'Test deskripsi wisata',
            'alamat'          => 'Jl. Test No. 1',
            'harga_tiket'     => 'Gratis',
            'jam_operasional' => '08:00 - 17:00 WIB',
        ]);

        $this->assertEquals($user->user_id, $wisata->created_by);
        $this->assertInstanceOf(User::class, $wisata->user);
        $this->assertEquals($user->user_id, $wisata->user->user_id);
        $this->assertTrue($user->wisata->contains('wisata_id', $wisata->wisata_id));

        // 5. Test Galeri relationship
        $galeri = Galeri::create([
            'created_by' => $user->user_id,
            'judul'      => 'Test Galeri ' . uniqid(),
            'kategori'   => 'kegiatan_desa',
            'foto'       => '/uploads/galeri/test.jpg',
            'is_active'  => true,
            'urutan'     => 1,
        ]);

        $this->assertEquals($user->user_id, $galeri->created_by);
        $this->assertInstanceOf(User::class, $galeri->user);
        $this->assertEquals($user->user_id, $galeri->user->user_id);
        $this->assertTrue($user->galeri->contains('galeri_id', $galeri->galeri_id));

        // 6. Test PendaftaranUmkm & Produk relationship
        $pendaftaran = PendaftaranUmkm::create([
            'nomor_pendaftaran' => 'UMKM-' . uniqid(),
            'user_id'           => $user->user_id,
            'nama_usaha'        => 'Usaha Warga Test',
            'nama_pemilik'      => 'Pak Test',
            'alamat_usaha'      => 'Dusun Jambelaer',
            'deskripsi_usaha'   => 'Produksi opak ketan',
            'produk'            => 'Opak Ketan Asli',
            'nomor_whatsapp'    => '081234567890',
            'status'            => 'disetujui',
        ]);

        $produk = UMKM::create([
            'created_by'          => $user->user_id,
            'pendaftaran_umkm_id' => $pendaftaran->pendaftaran_umkm_id,
            'title'               => 'Produk UMKM Test ' . uniqid(),
            'slug'                => 'produk-umkm-test-' . uniqid(),
            'producer'            => 'Pak Test',
            'price'               => 'Rp 15.000',
            'badge'               => 'Makanan',
            'category'            => ['makanan'],
            'img'                 => '/uploads/produk/test.jpg',
            'desc_short'          => 'Short desc',
            'desc_long'           => 'Long desc',
            'is_active'           => true,
            'urutan'              => 1,
        ]);

        $this->assertEquals($user->user_id, $produk->created_by);
        $this->assertEquals($pendaftaran->pendaftaran_umkm_id, $produk->pendaftaran_umkm_id);
        $this->assertInstanceOf(User::class, $produk->user);
        $this->assertInstanceOf(PendaftaranUmkm::class, $produk->pendaftaranUmkm);
        $this->assertEquals($user->user_id, $produk->user->user_id);
        $this->assertTrue($user->produk->contains('produk_id', $produk->produk_id));

        // 6b. Test AgendaAcara relationship
        $acara = AgendaAcara::create([
            'user_id'          => $user->user_id,
            'nama_acara'       => 'Pentas Seni Desa ' . uniqid(),
            'tanggal_acara'    => now()->addDays(5)->toDateString(),
            'waktu_acara'      => '09:00',
            'lokasi_acara'     => 'Balai Desa Jambelaer',
            'name'             => 'Panitia Desa',
            'deskripsi_acara'  => 'Pentas seni tahunan warga.',
            'dipublikasikan'   => true,
            'status'           => 'disetujui',
        ]);

        $this->assertEquals($user->user_id, $acara->user_id);
        $this->assertInstanceOf(User::class, $acara->user);
        $this->assertTrue($user->agendaAcara->contains('agenda_acara_id', $acara->agenda_acara_id));

        // 7. Test Struktur Desa relationship
        $struktur = StrukturDesa::create([
            'created_by' => $user->user_id,
            'nama'       => 'Anggota Test ' . uniqid(),
            'jabatan'    => 'Staff Test',
            'urutan'     => 99,
        ]);

        $this->assertEquals($user->user_id, $struktur->created_by);
        $this->assertInstanceOf(User::class, $struktur->user);
        $this->assertEquals($user->user_id, $struktur->user->user_id);
        $this->assertTrue($user->strukturDesa->contains('struktur_desa_id', $struktur->struktur_desa_id));

        // 8. Test ON DELETE SET NULL constraint behavior
        $user->delete();

        $berita->refresh();
        $budaya->refresh();
        $wisata->refresh();
        $galeri->refresh();
        $produk->refresh();
        $struktur->refresh();

        $this->assertNull($berita->created_by, 'Berita created_by should be NULL after user is deleted');
        $this->assertNull($budaya->created_by, 'Budaya created_by should be NULL after user is deleted');
        $this->assertNull($wisata->created_by, 'Wisata created_by should be NULL after user is deleted');
        $this->assertNull($galeri->created_by, 'Galeri created_by should be NULL after user is deleted');
        $this->assertNull($produk->created_by, 'Produk created_by should be NULL after user is deleted');
        $this->assertNull($struktur->created_by, 'StrukturDesa created_by should be NULL after user is deleted');

        // Clean up test data
        $berita->delete();
        $budaya->delete();
        $wisata->delete();
        $galeri->delete();
        $produk->delete();
        $pendaftaran->delete();
        $acara->delete();
        $struktur->delete();
    }
}
