<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom role pada tabel users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role', 20)->default('masyarakat')->after('password');
            }
        });

        // Set semua akun user lama menjadi admin
        DB::table('users')->where('role', 'masyarakat')->orWhereNull('role')->update([
            'role' => 'admin'
        ]);

        // 2. Tambah kolom nomor_pengajuan pada tabel pesan
        Schema::table('pesan', function (Blueprint $table) {
            if (!Schema::hasColumn('pesan', 'nomor_pengajuan')) {
                $table->string('nomor_pengajuan', 50)->nullable()->unique()->after('pesan_id');
            }
        });

        // Backfill nomor pengajuan untuk data lama
        $oldPesan = DB::table('pesan')->whereNull('nomor_pengajuan')->get();
        foreach ($oldPesan as $p) {
            $date = $p->created_at ? date('Ymd', strtotime($p->created_at)) : date('Ymd');
            $nomor = 'PJN-' . $date . '-' . str_pad($p->pesan_id, 4, '0', STR_PAD_LEFT);
            DB::table('pesan')->where('pesan_id', $p->pesan_id)->update(['nomor_pengajuan' => $nomor]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            if (Schema::hasColumn('pesan', 'nomor_pengajuan')) {
                $table->dropColumn('nomor_pengajuan');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
