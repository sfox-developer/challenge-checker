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
        // Drop the old index/key
        Schema::table('habits', function (Blueprint $table) {
            $table->dropIndex('habits_goal_library_id_foreign');
        });
        
        // Add proper foreign key constraint
        Schema::table('habits', function (Blueprint $table) {
            $table->foreign('goal_id')->references('id')->on('goals')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropForeign(['goal_id']);
        });
        
        Schema::table('habits', function (Blueprint $table) {
            $table->index('goal_id', 'habits_goal_library_id_foreign');
        });
    }
};
