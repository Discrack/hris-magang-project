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
            // Modify the profile_picture column to VARCHAR(255)
            $table->string('profile_picture', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            // Optional: define how to revert the change if needed.
            // Be cautious here, as reverting might cause data truncation
            // if you revert to a smaller size that cannot hold existing data.
            // Example: $table->string('profile_picture', PREVIOUS_LENGTH)->nullable()->change();
        });
    }
};