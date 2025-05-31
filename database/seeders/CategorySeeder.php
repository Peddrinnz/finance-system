<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Salário', 'icon' => 'cash', 'color' => '#4CAF50'],
            ['name' => 'Freelance', 'icon' => 'briefcase', 'color' => '#2196F3'],
            ['name' => 'Moradia', 'icon' => 'home', 'color' => '#9C27B0'],
            ['name' => 'Alimentação', 'icon' => 'food', 'color' => '#FF9800'],
            ['name' => 'Transporte', 'icon' => 'car', 'color' => '#FFEB3B'],
            ['name' => 'Lazer', 'icon' => 'ticket', 'color' => '#E91E63'],
            ['name' => 'Saúde', 'icon' => 'medical', 'color' => '#F44336'],
            ['name' => 'Educação', 'icon' => 'school', 'color' => '#3F51B5'],
            ['name' => 'Outros', 'icon' => 'dots', 'color' => '#607D8B'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}