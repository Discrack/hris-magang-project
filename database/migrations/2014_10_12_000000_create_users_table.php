<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // Menggunakan 'user_id' sebagai primary key
            $table->string('username', 50)->unique(); // Nama pengguna harus unik
            $table->string('password'); // Kolom untuk password yang terenkripsi
            $table->enum('role', ['admin', 'intern', 'mentor']); // Kolom untuk peran pengguna
            $table->rememberToken(); // Kolom untuk "remember me" functionality
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
