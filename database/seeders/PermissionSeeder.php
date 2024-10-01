<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['profile_view', 'profile_create', 'profile_edit', 'profile_delete', 
                        'permission_view', 'permission_create', 'permission_edit', 'permission_delete', 
                        'role_view', 'role_create', 'role_edit', 'role_delete',
                        'tables_view', 'tables_create', 'tables_edit', 'tables_delete',
                        'users_view', 'users_edit', 'users_delete',
                        'game_tables_view', 'game_tables_create', 'game_tables_edit', 'game_tables_delete',
                        'jackpots_view', 'jackpots_create', 'jackpots_edit', 'jackpots_delete',
                        'house_commissions_view',
                        'hands_view', 'hands_create', 'hands_edit', 'hands_delete',
                        'jackpot_winners_view','jackpot_winners_delete',
                        'bets_view',
                        'logs_view','logs_download',
                        'displays_view', 'displays_create', 'displays_edit', 'displays_delete',];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
