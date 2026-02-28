<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Tiered pricing allows admin to configure different per-mile rates
     * based on distance ranges (e.g., 1-3 miles, 3-5 miles, etc.)
     */
    public function up(): void
    {
        Schema::create('tiered_pricing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_type_zone_id');
            $table->decimal('min_distance', 10, 2)->default(0); // Minimum distance in miles/km
            $table->decimal('max_distance', 10, 2)->nullable(); // Null means unlimited (99+ miles)
            $table->decimal('per_distance_charge', 10, 2)->default(0); // Price per mile/km for this tier
            $table->integer('order')->default(0); // For sorting tiers
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vehicle_type_zone_id')
                ->references('id')
                ->on('vehicle_type_zones')
                ->onDelete('cascade');

            $table->foreign('created_by_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->index(['vehicle_type_zone_id', 'min_distance', 'max_distance'], 'tiered_pricing_lookup_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiered_pricing');
    }
};
