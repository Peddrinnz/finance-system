<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Pedro Ernesto',
                'email' => 'pedro@email.com',
                'password' => Hash::make('123456'),
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria@email.com',
                'password' => Hash::make('123456'),
            ],
            [
                'name' => 'João Paulo',
                'email' => 'joao@email.com',
                'password' => Hash::make('123456'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}