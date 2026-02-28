<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Coupon System Enhancement:
     * - Track individual coupon usage per ride
     * - Prevent coupon stacking (one coupon per trip)
     */
    public function up(): void
    {
        // Track coupon usage per ride
        if (!Schema::hasTable('coupon_usage')) {
            Schema::create('coupon_usage', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('coupon_id');
                $table->unsignedBigInteger('rider_id');
                $table->unsignedBigInteger('ride_id');
                $table->decimal('discount_amount', 10, 2)->default(0);
                $table->timestamps();

                $table->foreign('coupon_id')
                    ->references('id')
                    ->on('coupons')
                    ->onDelete('cascade');

                $table->foreign('rider_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

                $table->foreign('ride_id')
                    ->references('id')
                    ->on('rides')
                    ->onDelete('cascade');

                // Ensure one coupon per ride
                $table->unique(['ride_id'], 'one_coupon_per_ride');
                $table->index(['coupon_id', 'rider_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usage');
    }
};
