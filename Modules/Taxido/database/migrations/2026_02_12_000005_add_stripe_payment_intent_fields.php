<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Stripe PaymentIntents with manual capture:
     * - Authorise estimated fare at booking
     * - Void authorisation if cancelled before trip start
     * - Capture final fare on trip completion
     * - Refund automatically if capture occurs and trip is cancelled
     */
    public function up(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            // Stripe Payment Intent fields
            $table->string('stripe_payment_intent_id')->nullable()->after('payment_status');
            $table->string('stripe_payment_method_id')->nullable()->after('stripe_payment_intent_id');
            $table->decimal('authorised_amount', 10, 2)->nullable()->after('stripe_payment_method_id');
            $table->decimal('captured_amount', 10, 2)->nullable()->after('authorised_amount');
            $table->decimal('refunded_amount', 10, 2)->nullable()->after('captured_amount');
            $table->enum('payment_capture_status', [
                'pending',
                'authorised',
                'captured',
                'voided',
                'refunded',
                'failed'
            ])->default('pending')->after('refunded_amount');
            $table->timestamp('payment_authorised_at')->nullable()->after('payment_capture_status');
            $table->timestamp('payment_captured_at')->nullable()->after('payment_authorised_at');
            $table->timestamp('payment_voided_at')->nullable()->after('payment_captured_at');
            $table->timestamp('payment_refunded_at')->nullable()->after('payment_voided_at');
            $table->text('payment_error_message')->nullable()->after('payment_refunded_at');
            
            // Toll handling fields
            $table->decimal('estimated_toll', 10, 2)->default(0)->after('payment_error_message');
            $table->decimal('actual_toll', 10, 2)->default(0)->after('estimated_toll');
            $table->boolean('is_toll_capped')->default(true)->after('actual_toll');

            $table->index('stripe_payment_intent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->dropIndex(['stripe_payment_intent_id']);
            $table->dropColumn([
                'stripe_payment_intent_id',
                'stripe_payment_method_id',
                'authorised_amount',
                'captured_amount',
                'refunded_amount',
                'payment_capture_status',
                'payment_authorised_at',
                'payment_captured_at',
                'payment_voided_at',
                'payment_refunded_at',
                'payment_error_message',
                'estimated_toll',
                'actual_toll',
                'is_toll_capped'
            ]);
        });
    }
};
