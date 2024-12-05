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

        // User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@fms.com',
        //     'password'=> bcrypt('123456789'),

        // ]);
        $this->call([
            ClientSeeder::class,
            ProjectSeeder::class,
            TreasurySeeder::class,
            IncomeSeeder::class, 
            ExpenseSeeder::class,
        ]);
    }
}
