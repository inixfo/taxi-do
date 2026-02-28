<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Comprehensive Audit Logging System:
     * - Bank changes
     * - Driver approvals
     * - Payouts
     * - Coupons
     * - Manual photo deletion
     * - Driver photo lock/unlock
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Who performed the action
            $table->string('user_type')->nullable(); // admin, driver, rider, fleet_manager
            $table->string('action'); // create, update, delete, approve, reject, lock, unlock, etc.
            $table->string('auditable_type'); // Model class name
            $table->unsignedBigInteger('auditable_id'); // Model ID
            $table->string('event_type'); // bank_change, driver_approval, payout, coupon, photo_deletion, photo_lock
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->index(['auditable_type', 'auditable_id']);
            $table->index('event_type');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
