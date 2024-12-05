<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expense;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $expenses = [
            [
                'date' => now(),
                'accounting_id' => 'EXP001',
                'expense_type' => 'Logistics',
                'designation' => 'Delivery Charges',
                'basis' => 'Per Delivery',
                'description' => 'Shipping materials',
                'unit' => 'K.G',
                'unit_rate' => 50.00,
                'quantity' => 10,
                'total_amount' => 500.00,
                'recipient' => 'Logistics Company',
                'project_id' => 1,
            ],
            [
                'date' => now(),
                'accounting_id' => 'EXP002',
                'expense_type' => 'Material Purchases',
                'designation' => 'Raw Materials',
                'basis' => 'Per Unit',
                'description' => 'Purchased raw materials for project',
                'unit' => 'Set',
                'unit_rate' => 200.00,
                'quantity' => 5,
                'total_amount' => 1000.00,
                'recipient' => 'Supplier A',
                'project_id' => 2,
            ],
        ];

        foreach ($expenses as $expense) {
            Expense::create($expense);
        }
    }
}
