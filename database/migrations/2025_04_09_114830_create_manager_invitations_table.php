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
        Schema::create('manager_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('place_id')->constrained('places')->cascadeOnDelete();
            $table->string('phone_number');
            $table->string('token')->unique();
            $table->timestamp('expires_at');
            $table->timestamps();
            $table->softDeletes();
            
            // Prevent duplicate active invitations for same place+number
            $table->unique(['place_id', 'phone_number']); // Changed from phone+token
            
            // Add indexes for common queries
            $table->index('phone_number');
            $table->index('expires_at');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager_invitations');
    }
};
