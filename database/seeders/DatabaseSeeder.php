<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. RUN CATEGORIES FIRST 
        // This ensures categories exist so Books can link to them.
        $this->call([
            CategorySeeder::class,
        ]);

        // 2. CREATE THE ADMIN (Your primary account)
        User::create([
            'name' => 'Admin Jessa',
            'email' => 'admin@library.com',
            'password' => Hash::make('password123'),
            'role' => 'Admin',
            'status' => 'active',
        ]);

        // 3. CREATE A TEST LIBRARIAN
        User::create([
            'name' => 'Librarian User',
            'email' => 'librarian@library.com',
            'password' => Hash::make('password123'),
            'role' => 'Librarian',
            'status' => 'active',
        ]);

        // 4. CREATE A TEST STUDENT
        User::create([
            'name' => 'Student User',
            'email' => 'student@library.com',
            'password' => Hash::make('password123'),
            'role' => 'Student',
            'status' => 'active',
        ]);
    }
}