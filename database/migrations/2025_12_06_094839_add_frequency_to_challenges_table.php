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
        Schema::table('challenges', function (Blueprint $table) {
            // Add frequency fields similar to habits table
            $table->string('frequency_type')->default('daily')->after('days_duration');
            $table->integer('frequency_count')->default(1)->after('frequency_type');
            $table->json('frequency_config')->nullable()->after('frequency_count');
            
            // Make days_duration nullable for backward compatibility
            $table->integer('days_duration')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropColumn(['frequency_type', 'frequency_count', 'frequency_config']);
            $table->integer('days_duration')->nullable(false)->change();
        });
    }
};
