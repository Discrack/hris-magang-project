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
        Schema::create('payroll', function (Blueprint $table) {
            $table->id('payroll_id'); // Primary key untuk tabel payroll
            $table->unsignedBigInteger('intern_id'); // Foreign key ke interns
            $table->date('payment_date'); // Tanggal pembayaran gaji
            $table->decimal('amount', 10, 2); // Jumlah pembayaran
            $table->text('description')->nullable(); // Deskripsi pembayaran (opsional)
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
        Schema::dropIfExists('payroll');
    }
};
// This migration creates the 'payroll' table with the following columns:
// - `payroll_id`: Primary key untuk tabel payroll.
// - `intern_id`: Foreign key yang mengacu pada tabel interns.
// - `payment_date`: Tanggal pembayaran gaji yang dicatat sebagai date.
// - `amount`: Jumlah pembayaran yang dicatat sebagai decimal dengan 10 digit total dan 2 digit desimal.