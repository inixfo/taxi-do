<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Driver Payout System:
     * - Weekly automatic payouts
     * - Track payout history
     * - Log failed payouts
     */
    public function up(): void
    {
        Schema::create('driver_payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('GBP');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->string('stripe_transfer_id')->nullable();
            $table->string('stripe_payout_id')->nullable();
            $table->text('failure_reason')->nullable();
            $table->integer('failure_code')->nullable();
            $table->date('payout_period_start');
            $table->date('payout_period_end');
            $table->integer('rides_count')->default(0);
            $table->decimal('gross_earnings', 10, 2)->default(0);
            $table->decimal('commission_deducted', 10, 2)->default(0);
            $table->decimal('net_payout', 10, 2)->default(0);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->unsignedBigInteger('processed_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('driver_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('processed_by_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->index(['driver_id', 'status']);
            $table->index('stripe_transfer_id');
            $table->index('scheduled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_payouts');
    }
};
