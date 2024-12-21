<?php

namespace Database\Seeders;

use App\Models\Expense;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Expense::create([
            'name' => 'Office Supplies',
            'amount' => 5000.00,
        ]);

        Expense::create([
            'name' => 'Internet Bill',
            'amount' => 200.00,
        ]);
    }
    }

