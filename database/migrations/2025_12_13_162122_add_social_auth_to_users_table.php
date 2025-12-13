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
        Schema::table('users', function (Blueprint $table) {
            // Social authentication fields
            $table->string('provider')->nullable()->after('email');
            $table->string('provider_id')->nullable()->after('provider');
            $table->string('provider_token', 500)->nullable()->after('provider_id');
            $table->string('provider_refresh_token', 500)->nullable()->after('provider_token');
            $table->timestamp('provider_token_expires_at')->nullable()->after('provider_refresh_token');
            
            // Avatar from provider
            $table->string('avatar_url')->nullable()->after('avatar');
            
            // Make password nullable for social-only accounts
            $table->string('password')->nullable()->change();
            
            // Composite unique constraint for provider + provider_id
            $table->unique(['provider', 'provider_id'], 'provider_user_unique');
            
            // Index for faster lookups
            $table->index('provider');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('provider_user_unique');
            $table->dropIndex(['provider']);
            
            $table->dropColumn([
                'provider',
                'provider_id',
                'provider_token',
                'provider_refresh_token',
                'provider_token_expires_at',
                'avatar_url',
            ]);
            
            // Restore password as required (if possible)
            $table->string('password')->nullable(false)->change();
        });
    }
};
