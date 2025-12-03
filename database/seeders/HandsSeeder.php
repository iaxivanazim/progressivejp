<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hand;

class HandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hands = [];

        for ($i = 1; $i <= 36; $i++) {
            $hands[] = [
                'name' => 'Hand ' . $i,
                'deduction_type' => $i % 2 == 0 ? 'percentage' : 'fixed',
                'deduction_value' => $i % 2 == 0 ? rand(1, 10) : rand(50, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Hand::insert($hands);
    }
}
