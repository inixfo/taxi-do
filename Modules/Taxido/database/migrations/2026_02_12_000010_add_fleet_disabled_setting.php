<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Taxido\Models\TaxidoSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add fleet_disabled setting to disable fleet functionality.
     */
    public function up(): void
    {
        // Get current settings
        $setting = TaxidoSetting::first();
        
        if ($setting) {
            $values = $setting->taxido_values ?? [];
            
            // Add fleet_disabled to activation settings
            if (!isset($values['activation']['fleet_enabled'])) {
                $values['activation']['fleet_enabled'] = false; // Disabled by default as per client requirements
            }
            
            $setting->update(['taxido_values' => $values]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $setting = TaxidoSetting::first();
        
        if ($setting) {
            $values = $setting->taxido_values ?? [];
            
            if (isset($values['activation']['fleet_enabled'])) {
                unset($values['activation']['fleet_enabled']);
                $setting->update(['taxido_values' => $values]);
            }
        }
    }
};
