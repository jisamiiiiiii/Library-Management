<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Information Technology'],
            ['category_name' => 'Science & Mathematics'],
            ['category_name' => 'Fiction'],
            ['category_name' => 'History'],
            ['category_name' => 'General Reference'],
            ['category_name' => 'Non-Fiction'], 
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['category_name' => $cat['category_name']], $cat);
        }
    }
}