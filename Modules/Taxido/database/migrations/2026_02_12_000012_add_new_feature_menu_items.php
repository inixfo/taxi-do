<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add menu items for new features:
     * - Audit Logs
     * - Driver Payouts
     */
    public function up(): void
    {
        // Get the admin user ID (usually 1)
        $adminId = DB::table('users')->where('id', 1)->value('id') ?? 1;
        
        // Get the max sort order for proper positioning
        $maxSort = DB::table('menu_items')->where('menu', 1)->max('sort') ?? 100;
        
        // Find the Drivers parent menu item to add Driver Payouts under it
        $driversMenuId = DB::table('menu_items')
            ->where('menu', 1)
            ->where('route', 'admin.driver.index')
            ->value('id');
            
        // Add Audit Logs menu item (under Reports section if exists, or as standalone)
        $existingAuditLogs = DB::table('menu_items')->where('route', 'admin.audit-logs.index')->exists();
        if (!$existingAuditLogs) {
            DB::table('menu_items')->insert([
                'label' => 'Audit Logs',
                'route' => 'admin.audit-logs.index',
                'slug' => 'audit-logs',
                'permission' => 'activity_log.index',
                'parent' => 0,
                'module' => null,
                'section' => 'REPORTS',
                'sort' => $maxSort + 1,
                'icon' => 'ri-file-list-3-line',
                'menu' => 1,
                'depth' => 0,
                'status' => 1,
                'created_by_id' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Add Driver Payouts menu item (under Drivers section)
        $existingDriverPayouts = DB::table('menu_items')->where('route', 'admin.driver-payouts.index')->exists();
        if (!$existingDriverPayouts) {
            DB::table('menu_items')->insert([
                'label' => 'Driver Payouts',
                'route' => 'admin.driver-payouts.index',
                'slug' => 'driver-payouts',
                'permission' => 'withdraw_request.index',
                'parent' => $driversMenuId ?? 0,
                'module' => null,
                'section' => 'USER MANAGEMENT',
                'sort' => $maxSort + 2,
                'icon' => 'ri-money-dollar-circle-line',
                'menu' => 1,
                'depth' => $driversMenuId ? 1 : 0,
                'status' => 1,
                'created_by_id' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('menu_items')->where('route', 'admin.audit-logs.index')->delete();
        DB::table('menu_items')->where('route', 'admin.driver-payouts.index')->delete();
    }
};
