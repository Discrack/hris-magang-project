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
        Schema::create('mentors', function (Blueprint $table) {
            $table->id('mentor_id'); // Primary key untuk tabel mentors
            $table->unsignedBigInteger('user_id')->unique(); // Foreign key ke users, harus unik
            $table->string('full_name', 100);
            $table->string('email', 100);
            $table->string('phone_number', 20)->nullable(); // Nomor telepon (opsional)
            $table->string('department', 50)->nullable(); // Departemen mentor (opsional)
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at'

            // Definisi Foreign Key
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('mentors');
    }
};
