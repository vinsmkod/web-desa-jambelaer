<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budaya', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->string('title');
            $table->string('excerpt');
            $table->text('desc');
            $table->string('img')->nullable();
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budaya');
    }
};
