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
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id();

            // Foreign key with explicit naming
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->comment('Reference to users table');

            $table->char('code', 50)->collation('utf8mb4_bin')->comment('Case-sensitive verification token');
            $table->enum('code_type', [
                'manager_registration',
                'phone_verification',
                'password_reset'
            ])->comment('Type of verification flow');

            $table->timestamp('expires_at')->index();
            $table->boolean('is_verified')->default(false)->index();
            $table->timestamps();
            $table->softDeletes();

            // Optimized composite indexes
            $table->index(['user_id', 'code_type', 'is_verified'], 'vc_user_type_status');
            $table->index(['code', 'expires_at', 'is_verified'], 'vc_code_validity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_codes');
    }
};
