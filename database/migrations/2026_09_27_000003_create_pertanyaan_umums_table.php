<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pertanyaan_umums', function (Blueprint $table) {
            $table->bigIncrements('pertanyaan_id');
            $table->string('nomor_pertanyaan', 50)->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama', 255);
            $table->string('email', 255)->nullable();
            $table->string('no_whatsapp', 30)->nullable();
            $table->string('subjek', 255);
            $table->text('pertanyaan');
            $table->text('jawaban_admin')->nullable();
            $table->string('status', 30)->default('diajukan'); // diajukan, dijawab, selesai
            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_umums');
    }
};
