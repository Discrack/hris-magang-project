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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id('assessment_id'); // Primary key untuk tabel assessments
            $table->unsignedBigInteger('intern_id'); // Foreign key ke interns
            $table->unsignedBigInteger('mentor_id'); // Foreign key ke mentors
            $table->tinyInteger('rating'); // Nilai penilaian (misalnya, 1-5 atau 1-10)
            $table->text('feedback')->nullable(); // Umpan balik atau komentar (opsional)
            $table->date('assessment_date'); // Tanggal penilaian
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at'

            // Definisi Foreign Keys
            $table->foreign('intern_id')->references('intern_id')->on('interns')->onDelete('cascade');
            $table->foreign('mentor_id')->references('mentor_id')->on('mentors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};