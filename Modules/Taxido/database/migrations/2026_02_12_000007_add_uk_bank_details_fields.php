<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * UK Bank Details:
     * - Sort code + Account number
     * - Stored encrypted
     * - Masked in admin
     */
    public function up(): void
    {
        Schema::table('payment_accounts', function (Blueprint $table) {
            // UK Bank Details (encrypted)
            $table->text('uk_sort_code')->nullable()->after('paypal_email'); // Encrypted
            $table->text('uk_account_number')->nullable()->after('uk_sort_code'); // Encrypted
            $table->string('uk_account_holder_name')->nullable()->after('uk_account_number');
            $table->string('uk_bank_name')->nullable()->after('uk_account_holder_name');
            
            // Stripe Connect fields
            $table->string('stripe_connect_account_id')->nullable()->after('uk_bank_name');
            $table->string('stripe_connect_onboarding_status')->nullable()->after('stripe_connect_account_id');
            $table->boolean('stripe_connect_charges_enabled')->default(false)->after('stripe_connect_onboarding_status');
            $table->boolean('stripe_connect_payouts_enabled')->default(false)->after('stripe_connect_charges_enabled');
            $table->timestamp('stripe_connect_onboarded_at')->nullable()->after('stripe_connect_payouts_enabled');
            
            // Payout tracking
            $table->timestamp('last_payout_at')->nullable()->after('stripe_connect_onboarded_at');
            $table->decimal('last_payout_amount', 10, 2)->nullable()->after('last_payout_at');
            $table->string('last_payout_status')->nullable()->after('last_payout_amount');

            $table->index('stripe_connect_account_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_accounts', function (Blueprint $table) {
            $table->dropIndex(['stripe_connect_account_id']);
            $table->dropColumn([
                'uk_sort_code',
                'uk_account_number',
                'uk_account_holder_name',
                'uk_bank_name',
                'stripe_connect_account_id',
                'stripe_connect_onboarding_status',
                'stripe_connect_charges_enabled',
                'stripe_connect_payouts_enabled',
                'stripe_connect_onboarded_at',
                'last_payout_at',
                'last_payout_amount',
                'last_payout_status'
            ]);
        });
    }
};
