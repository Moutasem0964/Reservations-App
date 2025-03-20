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
        Schema::create('archived_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('table_id')->constrained('tables')->cascadeOnDelete();
            $table->foreignId('place_id')->constrained('places')->cascadeOnDelete();
            $table->timestamp('reservation_time');
            $table->integer('number');
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->text('decline_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('type');
            $table->timestamp('archived_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['place_id','reservation_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_reservations');
    }
};
