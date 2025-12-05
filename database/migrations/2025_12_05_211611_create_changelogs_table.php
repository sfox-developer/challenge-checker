<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('changelogs', function (Blueprint $table) {
            $table->id();
            $table->string('version', 50); // e.g., "1.0.0", "v2.1.3"
            $table->string('title'); // e.g., "New Features & Bug Fixes"
            $table->text('description')->nullable(); // Optional summary
            $table->text('changes'); // Main changelog content (supports markdown/html)
            $table->date('release_date'); // When this version was released
            $table->boolean('is_published')->default(false); // Show on public changelog
            $table->boolean('is_major')->default(false); // Highlight as major release
            $table->timestamps();
            
            // Indexes
            $table->index('release_date');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('changelogs');
    }
};
