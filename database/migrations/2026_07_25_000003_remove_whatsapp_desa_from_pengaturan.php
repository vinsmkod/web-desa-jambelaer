<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pengaturan')->whereIn('key', ['sosmed_whatsapp', 'desa_whatsapp'])->delete();
    }

    public function down(): void
    {
        //
    }
};
