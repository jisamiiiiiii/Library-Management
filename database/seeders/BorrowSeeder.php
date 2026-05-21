<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrow;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BorrowSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'Student')->get();
        $books = Book::all();
        $jayson = User::where('email', 'j.r@gmail.com')->first(); // Your VIP Top Reader

        if ($students->isEmpty() || $books->isEmpty()) return;

        // --- DASHBOARD: ACTIVITY TRENDS (Monthly Chart) ---
        // Generates 80 completed records spread over 5 months
        for ($i = 0; $i < 80; $i++) {
            $date = Carbon::now()->subMonths(rand(0, 5))->subDays(rand(1, 25));
            Borrow::create([
                'user_id'     => $students->random()->id,
                'book_id'     => $books->random()->id,
                'status'      => 'returned',
                'due_date'    => $date->copy()->addDays(7),
                'returned_at' => $date->copy()->addDays(rand(3, 6)),
                'created_at'  => $date,
                'updated_at'  => $date,
            ]);
        }

        // --- DASHBOARD: LIVE LOAN LEDGER (Active Borrows) ---
        // Generates 25 current loans to show in the Ledger
        for ($i = 0; $i < 25; $i++) {
            $book = $books->where('status', 'available')->random();
            $date = Carbon::now()->subDays(rand(1, 5));
            
            Borrow::create([
                'user_id'     => $students->random()->id,
                'book_id'     => $book->id,
                'status'      => 'borrowed',
                'due_date'    => Carbon::now()->addDays(rand(2, 10)),
                'created_at'  => $date,
                'updated_at'  => $date,
            ]);

            $book->update(['status' => 'borrowed']);
        }

        // --- DASHBOARD: TOP READERS (Force Jayson Romulo to #1) ---
        // We give Jayson an extra 15 completions to ensure he ranks first
        if ($jayson) {
            for ($i = 0; $i < 15; $i++) {
                Borrow::create([
                    'user_id'     => $jayson->id,
                    'book_id'     => $books->random()->id,
                    'status'      => 'returned',
                    'due_date'    => Carbon::now()->subMonth(),
                    'returned_at' => Carbon::now()->subMonth()->addDays(4),
                    'created_at'  => Carbon::now()->subMonth(),
                ]);
            }
        }

        // --- DASHBOARD: RECENTLY RETURNED & OVERDUE ---
        // Create 10 overdue records and 5 pending requests
        for ($i = 0; $i < 10; $i++) {
            $book = $books->where('status', 'available')->random();
            Borrow::create([
                'user_id'    => $students->random()->id,
                'book_id'    => $book->id,
                'status'     => 'borrowed',
                'due_date'   => Carbon::now()->subDays(rand(5, 10)),
                'created_at' => Carbon::now()->subDays(15),
            ]);
            $book->update(['status' => 'borrowed']);
        }

        for ($i = 0; $i < 5; $i++) {
            Borrow::create([
                'user_id'    => $students->random()->id,
                'book_id'    => $books->where('status', 'available')->random()->id,
                'status'     => 'pending',
                'created_at' => Carbon::now()->subHours(rand(1, 10)),
            ]);
        }
    }
}