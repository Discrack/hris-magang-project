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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('attendance_id'); // Primary key untuk tabel attendances
            $table->unsignedBigInteger('intern_id'); // Foreign key ke interns
            $table->dateTime('check_in_time'); // Waktu check-in
            $table->dateTime('check_out_time')->nullable(); // Waktu check-out (bisa null jika belum check-out)
            $table->date('attendance_date'); // Tanggal kehadiran
            $table->text('notes')->nullable(); // Catatan kehadiran (opsional)
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at'

            // Definisi Foreign Key
            $table->foreign('intern_id')->references('intern_id')->on('interns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
// This migration creates the 'attendances' table with the following columns:
// - `attendance_id`: Primary key untuk tabel attendances.
// - `intern_id`: Foreign key yang mengacu pada tabel interns.
// - `check_in_time`: Waktu check-in yang dicatat sebagai datetime. 