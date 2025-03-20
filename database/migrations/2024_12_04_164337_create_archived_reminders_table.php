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
        Schema::create('archived_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('reservation_id')->constrained('reservations')->cascadeOnDelete();
            $table->timestamp('reminder_time');
            $table->text('message');
            $table->boolean('is_custom')->default(false);
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->timestamp('archived_at')->nullable();
            $table->index('reminder_time');
            $table->index(['client_id','reservation_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_reminders');
    }
};
