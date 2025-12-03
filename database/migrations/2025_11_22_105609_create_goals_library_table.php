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
        Schema::create('goals_library', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'name']);
        });
        
        // Add goal_library_id to existing goals table
        Schema::table('goals', function (Blueprint $table) {
            $table->foreignId('goal_library_id')->nullable()->after('challenge_id')->constrained('goals_library')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->dropForeign(['goal_library_id']);
            $table->dropColumn('goal_library_id');
        });
        
        Schema::dropIfExists('goals_library');
    }
};
