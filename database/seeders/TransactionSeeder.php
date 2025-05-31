<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::create([
            'user_id' => 1,
            'category_id' => 1,
            'type' => 'income',
            'amount' => 5000.00,
            'description' => 'Salário mensal',
            'date' => '2024-01-15',
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 3,
            'type' => 'expense',
            'amount' => 1200.00,
            'description' => 'Aluguel',
            'date' => '2024-01-05',
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 4,
            'type' => 'expense',
            'amount' => 300.00,
            'description' => 'Supermercado',
            'date' => '2024-01-10',
        ]);

        Transaction::create([
            'user_id' => 2,
            'category_id' => 1,
            'type' => 'income',
            'amount' => 6000.00,
            'description' => 'Salário mensal',
            'date' => '2024-01-15',
        ]);

        Transaction::create([
            'user_id' => 2,
            'category_id' => 3,
            'type' => 'expense',
            'amount' => 1500.00,
            'description' => 'Financiamento',
            'date' => '2024-01-05',
        ]);

        Transaction::create([
            'user_id' => 2,
            'category_id' => 4,
            'type' => 'expense',
            'amount' => 400.00,
            'description' => 'Supermercado',
            'date' => '2024-01-10',
        ]);

        Transaction::create([
            'user_id' => 3,
            'category_id' => 1,
            'type' => 'income',
            'amount' => 4500.00,
            'description' => 'Salário mensal',
            'date' => '2024-01-15',
        ]);

        Transaction::create([
            'user_id' => 3,
            'category_id' => 3, 
            'type' => 'expense',
            'amount' => 800.00,
            'description' => 'Aluguel',
            'date' => '2024-01-05',
        ]);

        Transaction::create([
            'user_id' => 3,
            'category_id' => 5,
            'type' => 'expense',
            'amount' => 200.00,
            'description' => 'Passagem',
            'date' => '2024-01-10',
        ]);
    }
}