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
        Schema::create('calendar', function (Blueprint $table) {
            $table->id('event_id'); // Primary key untuk tabel calendar
            $table->string('title', 255); // Judul acara
            $table->text('description')->nullable(); // Deskripsi acara (opsional)
            $table->date('start_date'); // Tanggal mulai acara
            $table->date('end_date')->nullable(); // Tanggal berakhir acara (opsional)
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
        Schema::dropIfExists('calendar');
    }
};