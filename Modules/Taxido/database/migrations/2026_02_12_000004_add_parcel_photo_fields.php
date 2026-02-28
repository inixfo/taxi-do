<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Parcel Security System:
     * - Mandatory pickup photo
     * - Mandatory drop-off photo
     * - Order cannot be completed without required photos
     * - Photos visible to: Sender, Receiver, Admin
     */
    public function up(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->unsignedBigInteger('pickup_photo_id')->nullable()->after('cargo_image_id');
            $table->timestamp('pickup_photo_taken_at')->nullable()->after('pickup_photo_id');
            $table->unsignedBigInteger('dropoff_photo_id')->nullable()->after('pickup_photo_taken_at');
            $table->timestamp('dropoff_photo_taken_at')->nullable()->after('dropoff_photo_id');
            $table->boolean('is_parcel_photos_required')->default(false)->after('dropoff_photo_taken_at');

            $table->foreign('pickup_photo_id')
                ->references('id')
                ->on('media')
                ->onDelete('set null');

            $table->foreign('dropoff_photo_id')
                ->references('id')
                ->on('media')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->dropForeign(['pickup_photo_id']);
            $table->dropForeign(['dropoff_photo_id']);
            $table->dropColumn([
                'pickup_photo_id',
                'pickup_photo_taken_at',
                'dropoff_photo_id',
                'dropoff_photo_taken_at',
                'is_parcel_photos_required'
            ]);
        });
    }
};
