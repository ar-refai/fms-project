<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Treasury;

class TreasurySeeder extends Seeder
{
    public function run(): void
    {
        $treasuries = [
            [
                'treasury_id' => 'TR001',
                'date' => now(),
                'starting_balance' => 50000.00,
                'type' => 'Deposit',
                'amount' => 2000.00,
                'description' => 'Client Payment',
                'ending_balance' => 52000.00,
            ],
            [
                'treasury_id' => 'TR002',
                'date' => now(),
                'starting_balance' => 52000.00,
                'type' => 'Withdrawal',
                'amount' => 5000.00,
                'description' => 'Office Supplies',
                'ending_balance' => 47000.00,
            ],
        ];

        foreach ($treasuries as $treasury) {
            Treasury::create($treasury);
        }
    }
}
