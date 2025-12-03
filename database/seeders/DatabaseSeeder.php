<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            RolePermissionSeeder::class,
            HandsSeeder::class,
            // Add other seeders here
        ]);
        User::create([
            'role_id'=>'1',
            'name' => 'Admin',
            'username' => 'admin',
            'password'=>'$2y$12$.X.CkQnTNmQqbpsyS6SMlOtH5HtEyPvVOKo3k1EqnVfI3VojtRmNq',//'Password'
            'status'=>'Active',
            'pin'=>'1234',
        ]);
    }
}
