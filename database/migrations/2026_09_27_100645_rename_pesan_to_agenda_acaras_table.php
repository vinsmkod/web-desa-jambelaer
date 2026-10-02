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
        // 1. Buat tabel agenda_acaras jika belum ada
        if (!Schema::hasTable('agenda_acaras')) {
            Schema::create('agenda_acaras', function (Blueprint $table) {
                $table->bigIncrements('agenda_acara_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('nama_acara', 150);
                $table->date('tanggal_acara');
                $table->string('waktu_acara', 50)->nullable();
                $table->string('lokasi_acara', 255);
                $table->string('name', 100);
                $table->string('nama_instansi', 100)->nullable();
                $table->string('no_whatsapp', 25)->nullable();
                $table->integer('jumlah_peserta')->nullable()->default(0);
                $table->text('deskripsi_acara');
                $table->string('foto_bukti')->nullable();
                $table->string('dokumen_lampiran')->nullable();
                $table->string('status', 50)->default('disetujui');
                $table->boolean('dipublikasikan')->default(false);
                $table->boolean('is_archived')->default(false);
                $table->boolean('is_read')->default(true);
                $table->text('catatan_admin')->nullable();
                $table->timestamps();

                $table->foreign('user_id')
                    ->references('user_id')
                    ->on('users')
                    ->onDelete('set null');
            });
        }

        // 2. Pindahkan data agenda acara dari pesan jika ada
        if (Schema::hasTable('pesan')) {
            $acaraRows = DB::table('pesan')
                ->whereIn('jenis_pesan', ['agenda_acara', 'pengajuan_acara'])
                ->get();

            foreach ($acaraRows as $row) {
                DB::table('agenda_acaras')->insert([
                    'user_id'          => $row->user_id,
                    'nama_acara'       => $row->nama_acara ?: ($row->subject ?: 'Agenda Acara'),
                    'tanggal_acara'    => $row->tanggal_acara ?: date('Y-m-d'),
                    'waktu_acara'      => $row->waktu_acara,
                    'lokasi_acara'     => $row->lokasi_acara ?: 'Desa Jambelaer',
                    'name'             => $row->name ?: 'Pemerintah Desa',
                    'nama_instansi'    => $row->nama_instansi,
                    'no_whatsapp'      => $row->no_whatsapp,
                    'jumlah_peserta'   => $row->jumlah_peserta ?? 0,
                    'deskripsi_acara'  => $row->deskripsi_acara ?: ($row->message ?: '-'),
                    'foto_bukti'       => $row->foto_bukti,
                    'dokumen_lampiran' => $row->dokumen_lampiran,
                    'status'           => $row->status ?: 'disetujui',
                    'dipublikasikan'   => (bool)($row->dipublikasikan ?? false),
                    'is_archived'      => (bool)($row->is_archived ?? false),
                    'is_read'          => (bool)($row->is_read ?? true),
                    'catatan_admin'    => $row->catatan_admin,
                    'created_at'       => $row->created_at ?? now(),
                    'updated_at'       => $row->updated_at ?? now(),
                ]);
            }

            // 3. Lepaskan foreign key dari tabel produk ke tabel pesan
            if (Schema::hasTable('produk')) {
                Schema::table('produk', function (Blueprint $table) {
                    try {
                        $table->dropForeign('produk_pesan_id_foreign');
                    } catch (\Throwable $e) {}
                    
                    if (Schema::hasColumn('produk', 'pesan_id')) {
                        try {
                            $table->dropColumn('pesan_id');
                        } catch (\Throwable $e) {}
                    }
                });
            }

            // 4. Hapus tabel pesan lama
            Schema::dropIfExists('pesan');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe reverse
    }
};
