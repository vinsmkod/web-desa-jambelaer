<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buat tabel jenis_surat untuk pengelolaan jenis surat yang fleksibel oleh administrator
        if (!Schema::hasTable('jenis_surat')) {
            Schema::create('jenis_surat', function (Blueprint $table) {
                $table->id();
                $table->string('nama_surat', 255);
                $table->string('kode_surat', 50)->nullable();
                $table->text('deskripsi')->nullable();
                $table->text('persyaratan_khusus')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('urutan')->default(0);
                $table->timestamps();
            });

            // Seeding jenis surat standar Desa Jambelaer
            $initialTypes = [
                [
                    'nama_surat'         => 'Surat Keterangan Domisili',
                    'kode_surat'         => 'SKD',
                    'deskripsi'          => 'Surat keterangan bukti tempat tinggal resmi bagi warga yang berdomisili di wilayah Desa Jambelaer.',
                    'persyaratan_khusus' => 'KTP dan Kartu Keluarga (KK). Tambahan surat pengantar RT/RW jika diperlukan.',
                    'is_active'          => true,
                    'urutan'             => 1,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ],
                [
                    'nama_surat'         => 'Surat Keterangan Usaha',
                    'kode_surat'         => 'SKU',
                    'deskripsi'          => 'Surat keterangan bagi warga yang menjalankan usaha atau kegiatan niaga di Desa Jambelaer untuk keperluan perbankan, izin, atau permodalan.',
                    'persyaratan_khusus' => 'KTP, KK, dan foto tempat/produk usaha.',
                    'is_active'          => true,
                    'urutan'             => 2,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ],
                [
                    'nama_surat'         => 'Surat Keterangan Belum Menikah',
                    'kode_surat'         => 'SKBM',
                    'deskripsi'          => 'Surat keterangan status perkawinan belum pernah menikah untuk keperluan administrasi pernikahan, pekerjaan, atau beasiswa.',
                    'persyaratan_khusus' => 'KTP, KK, dan pernyataan belum menikah bermeterai jika diperlukan.',
                    'is_active'          => true,
                    'urutan'             => 3,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ],
                [
                    'nama_surat'         => 'Surat Keterangan Sudah Menikah',
                    'kode_surat'         => 'SKSM',
                    'deskripsi'          => 'Surat keterangan pengesahan status pernikahan bagi warga yang tercatat sah di lingkungan Desa Jambelaer.',
                    'persyaratan_khusus' => 'KTP suami-istri, KK, dan fotokopi Buku Nikah/Akta Perkawinan.',
                    'is_active'          => true,
                    'urutan'             => 4,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ],
                [
                    'nama_surat'         => 'Surat Keterangan Ahli Waris',
                    'kode_surat'         => 'SKAW',
                    'deskripsi'          => 'Surat keterangan penetapan dan kesaksian para ahli waris dari pewaris yang telah meninggal dunia.',
                    'persyaratan_khusus' => 'KTP seluruh ahli waris, KK, Surat Kematian Pewaris, dan silsilah keluarga.',
                    'is_active'          => true,
                    'urutan'             => 5,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ],
                [
                    'nama_surat'         => 'Surat Keterangan Miskin',
                    'kode_surat'         => 'SKTM',
                    'deskripsi'          => 'Surat keterangan tidak mampu bagi keluarga kurang mampu untuk keperluan bantuan sosial, keringanan biaya pendidikan, atau kesehatan.',
                    'persyaratan_khusus' => 'KTP, KK, dan surat pengantar dari RT/RW setempat.',
                    'is_active'          => true,
                    'urutan'             => 6,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ],
                [
                    'nama_surat'         => 'Surat Pernyataan',
                    'kode_surat'         => 'SP',
                    'deskripsi'          => 'Surat keterangan atau legalisasi pernyataan resmi warga di hadapan Pemerintah Desa Jambelaer.',
                    'persyaratan_khusus' => 'KTP, KK, dan draf isi pernyataan.',
                    'is_active'          => true,
                    'urutan'             => 7,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ],
            ];

            DB::table('jenis_surat')->insert($initialTypes);
        }

        // 2. Modifikasi tabel pesan untuk mendukung pengajuan surat secara fleksibel
        Schema::table('pesan', function (Blueprint $table) {
            // Ubah jenis_pesan menjadi VARCHAR(50) agar tidak dibatasi enum lama
            DB::statement("ALTER TABLE `pesan` MODIFY `jenis_pesan` VARCHAR(50) NOT NULL DEFAULT 'pertanyaan_umum'");

            // Tambahkan relasi ke jenis_surat
            if (!Schema::hasColumn('pesan', 'jenis_surat_id')) {
                $table->unsignedBigInteger('jenis_surat_id')->nullable()->after('jenis_pesan');
                $table->foreign('jenis_surat_id')->references('id')->on('jenis_surat')->nullOnDelete();
            }

            // Data kependudukan pemohon surat
            if (!Schema::hasColumn('pesan', 'nik')) {
                $table->string('nik', 20)->nullable()->after('jenis_surat_id');
            }
            if (!Schema::hasColumn('pesan', 'no_kk')) {
                $table->string('no_kk', 20)->nullable()->after('nik');
            }
            if (!Schema::hasColumn('pesan', 'alamat_pemohon')) {
                $table->text('alamat_pemohon')->nullable()->after('no_kk');
            }
            if (!Schema::hasColumn('pesan', 'keperluan')) {
                $table->text('keperluan')->nullable()->after('alamat_pemohon');
            }

            // File persyaratan pengajuan surat (KTP, KK, Dokumen Pendukung)
            if (!Schema::hasColumn('pesan', 'file_ktp')) {
                $table->string('file_ktp', 255)->nullable()->after('keperluan');
            }
            if (!Schema::hasColumn('pesan', 'file_kk')) {
                $table->string('file_kk', 255)->nullable()->after('file_ktp');
            }
            if (!Schema::hasColumn('pesan', 'dokumen_pendukung')) {
                $table->string('dokumen_pendukung', 255)->nullable()->after('file_kk');
            }
            if (!Schema::hasColumn('pesan', 'keterangan_tambahan')) {
                $table->text('keterangan_tambahan')->nullable()->after('dokumen_pendukung');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            if (Schema::hasColumn('pesan', 'jenis_surat_id')) {
                $table->dropForeign(['jenis_surat_id']);
                $table->dropColumn('jenis_surat_id');
            }
            $cols = ['nik', 'no_kk', 'alamat_pemohon', 'keperluan', 'file_ktp', 'file_kk', 'dokumen_pendukung', 'keterangan_tambahan'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('pesan', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::dropIfExists('jenis_surat');
    }
};
