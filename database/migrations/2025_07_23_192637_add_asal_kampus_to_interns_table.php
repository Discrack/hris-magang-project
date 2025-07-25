<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            // Menambahkan kolom asal_kampus setelah kolom batch, bisa nullable
            $table->string('asal_kampus', 100)->nullable()->after('batch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            // Menghapus kolom asal_kampus jika rollback
            $table->dropColumn('asal_kampus');
        });
    }
};