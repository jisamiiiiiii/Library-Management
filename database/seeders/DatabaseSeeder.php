<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CLEAN SLATE
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Borrow::truncate();
        User::truncate();
        Category::truncate(); 
        Book::truncate();     
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. RUN SUB-SEEDERS
        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
        ]);

        $password = Hash::make('123456');

        // 3. ADMIN
        User::create([
            'name' => 'Jhun bart Macirin',
            'email' => 'j.b@gmail.com',
            'password' => $password,
            'role' => 'Admin',
            'status' => 'active',
            'department' => 'Administration',
            'contact_number' => '0912-345-6789',
        ]);

        // 4. LIBRARIANS (Your Main account + 10 extras)
        User::create([
            'name' => 'Librarian Professional',
            'email' => 'lib@gmail.com',
            'password' => $password,
            'role' => 'Librarian',
            'status' => 'active',
            'department' => 'Library Services',
            'contact_number' => '0911-222-3333',
        ]);

        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => fake()->firstName() . ' ' . fake()->lastName(),
                'email' => "librarian$i@gmail.com",
                'password' => $password,
                'role' => 'Librarian',
                'status' => 'active',
                'department' => 'Library Staff',
                'contact_number' => fake()->numerify('09##-###-####'),
            ]);
        }

        // 5. STUDENTS
        $jayson = User::create([
            'name' => 'Jayson Romulo',
            'email' => 'j.r@gmail.com',
            'password' => $password,
            'role' => 'Student',
            'status' => 'active',
            'department' => 'CCS',
            'contact_number' => '0999-888-7777',
            'year_level' => '4th Year',
        ]);

        $students = [$jayson];
        $depts = ['CCS', 'COE', 'CBA', 'CAS', 'CON', 'CHM'];
        $years = ['1st Year', '2nd Year', '3rd Year', '4th Year'];
        
        for ($i = 1; $i <= 60; $i++) {
            $normalName = fake()->firstName() . ' ' . fake()->lastName();

            $students[] = User::create([
                'name' => $normalName,
                'email' => "student$i@gmail.com",
                'password' => $password,
                'role' => 'Student',
                'status' => 'active',
                'department' => $depts[array_rand($depts)],
                'year_level' => $years[array_rand($years)],
                'contact_number' => fake()->numerify('09##-###-####'),
            ]);
        }

        // 6. DASHBOARD DATA
        $bookIds = Book::pluck('id')->toArray();

        // Activity Trends
        for ($i = 0; $i < 100; $i++) {
            $createdDate = Carbon::now()->subMonths(rand(0, 4))->subDays(rand(1, 30));
            Borrow::forceCreate([
                'user_id' => $students[array_rand($students)]->id,
                'book_id' => $bookIds[array_rand($bookIds)],
                'status' => 'returned',
                'due_date' => (clone $createdDate)->addDays(7),
                'returned_at' => (clone $createdDate)->addDays(rand(2, 10)),
                'created_at' => $createdDate,
                'updated_at' => $createdDate,
            ]);
        }

        // Live Ledger
        for ($i = 0; $i < 25; $i++) {
            Borrow::forceCreate([
                'user_id' => $students[array_rand($students)]->id,
                'book_id' => $bookIds[array_rand($bookIds)],
                'status' => 'borrowed',
                'due_date' => Carbon::now()->addDays(rand(1, 14)),
                'created_at' => Carbon::now()->subDays(rand(1, 5)),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Top Reader (Jayson)
        for ($i = 0; $i < 15; $i++) {
            Borrow::forceCreate([
                'user_id' => $jayson->id,
                'book_id' => $bookIds[array_rand($bookIds)],
                'status' => 'returned',
                'due_date' => Carbon::now()->subMonths(1),
                'returned_at' => Carbon::now()->subMonths(1)->addDays(3),
                'created_at' => Carbon::now()->subMonths(1),
                'updated_at' => Carbon::now(),
            ]);
        }

        $this->command->info("Directory populated with Admin, 11 Librarians, and 61 Students!");
    }
}