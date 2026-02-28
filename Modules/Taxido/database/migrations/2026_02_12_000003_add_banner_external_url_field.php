<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Enable clickable in-app banners with external URLs only
     */
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('external_url', 500)->nullable()->after('banner_image_id');
            $table->boolean('is_clickable')->default(true)->after('external_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['external_url', 'is_clickable']);
        });
    }
};
