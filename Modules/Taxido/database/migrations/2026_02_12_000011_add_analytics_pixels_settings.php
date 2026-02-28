<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add TikTok and Snapchat pixel settings to the analytics section.
     */
    public function up(): void
    {
        // Get current settings
        $setting = Setting::first();
        
        if ($setting) {
            $values = $setting->values ?? [];
            
            // Add TikTok and Snapchat pixel settings to analytics
            if (!isset($values['analytics']['tiktok_pixel_id'])) {
                $values['analytics']['tiktok_pixel_id'] = '';
            }
            if (!isset($values['analytics']['snapchat_pixel_id'])) {
                $values['analytics']['snapchat_pixel_id'] = '';
            }
            
            $setting->update(['values' => $values]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $setting = Setting::first();
        
        if ($setting) {
            $values = $setting->values ?? [];
            
            if (isset($values['analytics']['tiktok_pixel_id'])) {
                unset($values['analytics']['tiktok_pixel_id']);
            }
            if (isset($values['analytics']['snapchat_pixel_id'])) {
                unset($values['analytics']['snapchat_pixel_id']);
            }
            
            $setting->update(['values' => $values]);
        }
    }
};
