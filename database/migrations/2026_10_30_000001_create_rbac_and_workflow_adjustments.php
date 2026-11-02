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
        // 1. Perbarui tabel users: dukung multi-role perangkat desa & jabatan
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->string('role', 50)->default('masyarakat')->change();
            }
            if (!Schema::hasColumn('users', 'jabatan')) {
                $table->string('jabatan', 100)->nullable()->after('role');
            }
        });

        // 2. Tambah kategori pada tabel berita untuk diferensiasi wewenang Kasi Pemerintahan & Staff Desa
        Schema::table('berita', function (Blueprint $table) {
            if (!Schema::hasColumn('berita', 'kategori')) {
                $table->string('kategori', 50)->default('umum')->after('penulis');
                $table->index('kategori');
            }
        });

        // 3. Tambah kolom pencatatan workflow pada pengajuan_surats
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            if (!Schema::hasColumn('pengajuan_surats', 'diproses_by')) {
                $table->unsignedBigInteger('diproses_by')->nullable()->after('catatan_admin');
                $table->timestamp('diproses_at')->nullable()->after('diproses_by');
            }
            if (!Schema::hasColumn('pengajuan_surats', 'diverifikasi_by')) {
                $table->unsignedBigInteger('diverifikasi_by')->nullable()->after('diproses_at');
                $table->timestamp('diverifikasi_at')->nullable()->after('diverifikasi_by');
            }
            if (!Schema::hasColumn('pengajuan_surats', 'disetujui_by')) {
                $table->unsignedBigInteger('disetujui_by')->nullable()->after('diverifikasi_at');
                $table->timestamp('disetujui_at')->nullable()->after('disetujui_by');
            }
        });

        // 4. Tabel riwayat tracking proses pengajuan surat
        if (!Schema::hasTable('riwayat_pengajuan_surats')) {
            Schema::create('riwayat_pengajuan_surats', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('pengajuan_surat_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('actor_name', 150);
                $table->string('actor_role', 50);
                $table->string('status_awal', 30);
                $table->string('status_baru', 30);
                $table->text('catatan')->nullable();
                $table->timestamp('created_at')->useCurrent();

                $table->foreign('pengajuan_surat_id')
                    ->references('pengajuan_surat_id')
                    ->on('pengajuan_surats')
                    ->onDelete('cascade');

                $table->foreign('user_id')
                    ->references('user_id')
                    ->on('users')
                    ->onDelete('set null');

                $table->index('pengajuan_surat_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pengajuan_surats');

        Schema::table('pengajuan_surats', function (Blueprint $table) {
            if (Schema::hasColumn('pengajuan_surats', 'disetujui_at')) {
                $table->dropColumn(['disetujui_at', 'disetujui_by', 'diverifikasi_at', 'diverifikasi_by', 'diproses_at', 'diproses_by']);
            }
        });

        Schema::table('berita', function (Blueprint $table) {
            if (Schema::hasColumn('berita', 'kategori')) {
                $table->dropColumn('kategori');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'jabatan')) {
                $table->dropColumn('jabatan');
            }
        });
    }
};

