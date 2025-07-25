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
        Schema::create('interns', function (Blueprint $table) {
            $table->id('intern_id'); // Primary key untuk tabel interns
            $table->unsignedBigInteger('user_id')->unique(); // Foreign key ke users, harus unik
            $table->string('full_name', 100);
            $table->string('email', 100);
            $table->string('phone_number', 20)->nullable();
            $table->string('batch', 50)->nullable();
            $table->unsignedBigInteger('mentor_id')->nullable(); // Foreign key ke mentors, bisa null jika belum ada mentor
            $table->date('joining_date'); // Tanggal bergabung program magang
            $table->date('termination_date')->nullable(); // Tanggal berakhir program magang (opsional)
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at'

            // Definisi Foreign Keys
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('mentor_id')->references('mentor_id')->on('mentors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('interns');
    }
};
