<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Driver profile photo lock system:
     * - Photo is locked after admin approval
     * - Driver cannot change photo unless admin unlocks
     * - All admin actions are logged
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_photo_locked')->default(false)->after('is_verified');
            $table->unsignedBigInteger('photo_locked_by')->nullable()->after('is_photo_locked');
            $table->timestamp('photo_locked_at')->nullable()->after('photo_locked_by');
            $table->unsignedBigInteger('photo_unlocked_by')->nullable()->after('photo_locked_at');
            $table->timestamp('photo_unlocked_at')->nullable()->after('photo_unlocked_by');

            $table->foreign('photo_locked_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('photo_unlocked_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['photo_locked_by']);
            $table->dropForeign(['photo_unlocked_by']);
            $table->dropColumn([
                'is_photo_locked',
                'photo_locked_by',
                'photo_locked_at',
                'photo_unlocked_by',
                'photo_unlocked_at'
            ]);
        });
    }
};
