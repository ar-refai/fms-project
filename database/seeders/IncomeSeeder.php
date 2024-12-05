<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Income;

class IncomeSeeder extends Seeder
{
    public function run(): void
    {
        $incomes = [
            [
                'accounting_id' => 'INC001',
                'date' => now(),
                'project_id' => 1,
                'instalment_type' => 'Instalment',
                'designation' => 'Project Instalment',
                'basis' => 'Contract Basis',
                'total_amount' => 5000.00,
                'collection_type' => 'Bank Transfer',
            ],
            [
                'accounting_id' => 'INC002',
                'date' => now(),
                'project_id' => 2,
                'instalment_type' => 'Down-Payment',
                'designation' => 'Initial Payment',
                'basis' => 'Contract Basis',
                'total_amount' => 3000.00,
                'collection_type' => 'Cash',
            ],
        ];

        foreach ($incomes as $income) {
            Income::create($income);
        }
    }
}
