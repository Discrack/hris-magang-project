<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            // Jika kolom profile_picture sudah ada dengan tipe INT,
            // kita akan menghapusnya terlebih dahulu, lalu menambahkannya kembali dengan tipe yang benar.
            // Pastikan tidak ada data penting di kolom ini yang akan hilang saat drop.
            // Jika ada data yang perlu migrasi, akan membutuhkan langkah manual/kompleks.
            // Untuk kasus ini, kita asumsikan data di kolom ini masih bisa diabaikan
            // karena baru error.

            // Hapus kolom yang salah tipe
            $table->dropColumn('profile_picture');
        });

        Schema::table('interns', function (Blueprint $table) {
            // Tambahkan kembali kolom dengan tipe data string (VARCHAR)
            // Panjang 255 karakter seharusnya cukup untuk nama file
            $table->string('profile_picture', 255)->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            // Untuk rollback:
            // Hapus kolom string yang benar
            $table->dropColumn('profile_picture');
        });

        Schema::table('interns', function (Blueprint $table) {
            // Dan (opsional, jika Anda benar-benar ingin mengembalikan ke INT(11) )
            // Menambahkannya kembali sebagai integer seperti semula (ini hanya untuk rollback yang akurat)
            // $table->integer('profile_picture')->nullable()->after('email');
        });
    }
};