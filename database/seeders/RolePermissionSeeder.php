<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermissions = [
            ['role_id' => 1, 'permission_id' => 9],
            ['role_id' => 1, 'permission_id' => 10],
            ['role_id' => 1, 'permission_id' => 11],
            // Add more entries as needed
        ];

        DB::table('role_permission')->insert($rolePermissions);
    }
}
