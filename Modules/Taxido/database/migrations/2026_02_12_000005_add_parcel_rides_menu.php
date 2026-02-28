<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\MenuItems;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Find the parent "Rides" menu item
        $parentMenu = MenuItems::where('slug', 'tx_ride')->first();
        
        if ($parentMenu) {
            // Check if parcel rides menu doesn't already exist
            $existingMenu = MenuItems::where('slug', 'tx_parcel_rides')->first();
            
            if (!$existingMenu) {
                // Find the "All Rides" menu to get the sort order
                $allRidesMenu = MenuItems::where('slug', 'tx_all_rides')->first();
                $sortOrder = $allRidesMenu ? $allRidesMenu->sort + 1 : 83;
                
                MenuItems::create([
                    'label' => 'taxido::static.rides.parcel_rides',
                    'route' => 'admin.ride.service.filter',
                    'params' => json_encode(['service' => 'parcel']),
                    'slug' => 'tx_parcel_rides',
                    'permission' => 'ride.index',
                    'parent' => $parentMenu->id,
                    'section' => 'static.home',
                    'sort' => $sortOrder,
                    'icon' => 'ri-box-3-line',
                    'depth' => 1,
                    'menu' => 1,
                    'status' => 1,
                    'badgeable' => 1,
                    'badge' => 0,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        MenuItems::where('slug', 'tx_parcel_rides')->delete();
    }
};
