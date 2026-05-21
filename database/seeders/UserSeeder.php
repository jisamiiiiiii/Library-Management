<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('123456');
        $depts = ['CCS', 'COE', 'CBA', 'CON', 'CAS', 'CHM'];
        $years = ['1st Year', '2nd Year', '3rd Year', '4th Year'];

        // --- 1. THE "VIP" ACCOUNTS (Fixed for Login) ---
        
        // Admin: Jhun bart Macirin
        User::create([
            'name' => 'Jhun bart Macirin',
            'email' => 'j.b@gmail.com',
            'role' => 'Admin',
            'department' => 'Administration',
            'year_level' => null, // Staff don't have year levels
            'contact_number' => '0911-111-1111',
            'status' => 'Active',
            'password' => $password,
        ]);

        // Student: Jayson Romulo
        User::create([
            'name' => 'Jayson Romulo',
            'email' => 'j.r@gmail.com',
            'role' => 'Student',
            'department' => 'CCS',
            'year_level' => '3rd Year',
            'contact_number' => '0922-222-2222',
            'status' => 'Active',
            'password' => $password,
        ]);

        // --- 2. THE LIBRARIAN STAFF ---
        User::create([
            'name' => 'Maria Librada',
            'email' => 'librarian@gmail.com',
            'role' => 'Librarian',
            'department' => 'Library Services',
            'year_level' => null,
            'contact_number' => '0933-333-3333',
            'status' => 'Active',
            'password' => $password,
        ]);

        User::create([
    'name' => 'Alfred Streich',
    'email' => 'student16@gmail.com',
    'role' => 'Student',
    'department' => 'COE', // NOT 'dept'
    'year_level' => '2nd Year',
    'contact_number' => '0917-123-4567',
    'password' => Hash::make('123456'),
    'status' => 'Active',
]);

        // --- 3. MASS POPULATION (Member Directory) ---

        // Create 50 unique students to fill the directory
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => fake()->name(),
                'email' => "student{$i}@gmail.com",
                'role' => 'Student',
                'department' => $depts[array_rand($depts)],
                'year_level' => $years[array_rand($years)], // Populates the Indigo text in your UI
                'contact_number' => '09' . rand(10, 99) . '-' . rand(100, 999) . '-' . rand(1000, 9999),
                'status' => fake()->randomElement(['Active', 'Active', 'Inactive']), 
                'password' => $password,
            ]);
        }

        // Specifically adding Brendan Glover with full details
        User::create([
            'name' => 'Brendan Glover',
            'email' => 'brendan.g@gmail.com',
            'role' => 'Student',
            'department' => 'CCS',
            'year_level' => '4th Year',
            'contact_number' => '0915-442-1290',
            'status' => 'Active',
            'password' => $password,
        ]);
    }
}