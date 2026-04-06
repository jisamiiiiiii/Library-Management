<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the categories table.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Information Technology'],
            ['category_name' => 'Science & Mathematics'],
            ['category_name' => 'Fiction'],
            ['category_name' => 'History'],
            ['category_name' => 'General Reference'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}