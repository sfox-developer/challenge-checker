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
        Schema::table('goals_library', function (Blueprint $table) {
            // Drop the old string category column
            $table->dropColumn('category');
        });
        
        Schema::table('goals_library', function (Blueprint $table) {
            // Add new foreign key category_id column
            $table->foreignId('category_id')->nullable()->after('description')->constrained('categories')->onDelete('set null');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goals_library', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
        
        Schema::table('goals_library', function (Blueprint $table) {
            $table->string('category')->nullable()->after('description');
        });
    }
};
