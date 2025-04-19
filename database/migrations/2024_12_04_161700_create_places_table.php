<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First create the table without spatial columns
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone_number')->unique()->nullable();
            $table->enum('type', ['restaurant', 'cafe']);
            $table->integer('reservation_duration')->default(3);
            $table->text('description')->nullable();
            $table->string('photo_path')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // Add spatial columns using raw SQL that works on all MySQL versions
        DB::statement("
            ALTER TABLE places
            ADD COLUMN location POINT NOT NULL,
            ADD COLUMN latitude DECIMAL(10,8) AS (ST_Y(location)) STORED,
            ADD COLUMN longitude DECIMAL(10,8) AS (ST_X(location)) STORED
        ");

        // Set default value in a separate statement
        DB::statement("UPDATE places SET location = POINT(0, 0)");

        // Add indexes
        Schema::table('places', function (Blueprint $table) {
            $table->spatialIndex('location');
            $table->index(['type', 'latitude', 'longitude']);
            $table->index(['is_active', 'type']);
            $table->index(['deleted_at', 'type']);
            $table->fulltext(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
