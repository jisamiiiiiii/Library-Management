<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        $popularBooks = [
            'Information Technology' => [
                'Clean Code', 'The Pragmatic Programmer', 'Introduction to Algorithms', 
                'Design Patterns', 'Structure and Interpretation of Computer Programs',
                'Compilers: Principles, Techniques, and Tools', 'Modern Operating Systems',
                'Computer Networking: A Top-Down Approach', 'Artificial Intelligence: A Modern Approach',
                'The Art of Computer Programming', 'Code Complete', 'Refactoring',
                'Head First Design Patterns', 'Soft Skills: The Software Developer\'s Life Manual',
                'Eloquent JavaScript', 'You Don\'t Know JS', 'Learning Python', 
                'Java: The Complete Reference', 'C++ Primer', 'Database System Concepts'
            ],
            'Science & Mathematics' => [
                'A Brief History of Time', 'The Selfish Gene', 'Cosmos', 'The Elegant Universe',
                'Silent Spring', 'The Double Helix', 'Astrophysics for People in a Hurry',
                'The Man Who Knew Infinity', 'Godel, Escher, Bach', 'Principles of Mathematical Analysis',
                'Calculus', 'Linear Algebra Done Right', 'Elements of Statistical Learning',
                'The Origin of Species', 'Sapiens: A Brief History of Humankind',
                'What Is Life?', 'The Feynman Lectures on Physics', 'Introduction to Electrodynamics',
                'General Chemistry', 'Molecular Biology of the Cell'
            ],
            'Fiction' => [
                'The Great Gatsby', 'To Kill a Mockingbird', '1984', 'Brave New World',
                'The Catcher in the Rye', 'The Lord of the Rings', 'The Hobbit', 
                'Harry Potter and the Sorcerer\'s Stone', 'Pride and Prejudice',
                'The Alchemist', 'The Book Thief', 'Life of Pi', 'The Kite Runner',
                'One Hundred Years of Solitude', 'The Chronicles of Narnia',
                'Fahrenheit 451', 'The Handmaid\'s Tale', 'A Game of Thrones',
                'Dune', 'Neuromancer'
            ],
            'History' => [
                'The Guns of August', 'The Rise and Fall of the Third Reich', 'Guns, Germs, and Steel',
                'A People\'s History of the United States', 'The Silk Roads', 'Rubicon',
                'Team of Rivals', 'The History of the Ancient World', 'Battle Cry of Freedom',
                'SPQR: A History of Ancient Rome', 'The Crusades', 'Napoleon: A Life',
                'The Wright Brothers', '1776', 'The Diary of a Young Girl',
                'Bury My Heart at Wounded Knee', 'The Great Sea', 'Chernobyl: History of a Tragedy',
                'Stalin: Paradoxes of Power', 'The Anarchy'
            ],
            'General Reference' => [
                'Oxford English Dictionary', 'The World Almanac', 'Merriam-Webster Collegiate Dictionary',
                'Guinness World Records 2026', 'The Elements of Style', 'Chicago Manual of Style',
                'Roget\'s Thesaurus', 'The Encyclopedia Britannica', 'The CIA World Factbook',
                'Physicians\' Desk Reference', 'Atlas of the World', 'The Merck Manual',
                'Black\'s Law Dictionary', 'Pharmacopeia of the Philippines',
                'Statesman\'s Yearbook', 'The Britannica Guide to History'
            ],
            'Non-Fiction' => [
                'Thinking, Fast and Slow', 'Atomic Habits', 'The Power of Habit',
                'Educated', 'The Immortal Life of Henrietta Lacks', 'Into the Wild',
                'The Tipping Point', 'Outliers', 'Freakonomics', 'Quiet: The Power of Introverts',
                'The 7 Habits of Highly Effective People', 'Daring Greatly', 'Man\'s Search for Meaning',
                'How to Win Friends and Influence People', 'The Emperor of All Maladies',
                'When Breath Becomes Air', 'The 48 Laws of Power', 'Rich Dad Poor Dad'
            ],
        ];

        foreach ($popularBooks as $categoryName => $titles) {
            $category = $categories->where('category_name', $categoryName)->first();

            if ($category) {
                foreach ($titles as $title) {
                    Book::create([
                        'title' => $title,
                        'author' => fake()->name(),
                        'isbn' => fake()->isbn13(),
                        'category_id' => $category->id,
                        'department' => $categoryName, // Keeping it consistent
                        'location' => 'Shelf ' . rand(1, 20) . '-' . chr(rand(65, 70)),
                        'status' => fake()->randomElement(['available', 'available', 'available', 'borrowed']),
                        'summary' => fake()->paragraph(),
                    ]);
                }

                // Add random filler books to reach "many"
                foreach (range(1, 10) as $i) {
                    Book::create([
                        'title' => fake()->sentence(3) . " (Volume $i)",
                        'author' => fake()->name(),
                        'isbn' => fake()->isbn13(),
                        'category_id' => $category->id,
                        'department' => $categoryName,
                        'location' => 'Shelf ' . rand(1, 20) . '-' . chr(rand(65, 70)),
                        'status' => 'available',
                        'summary' => fake()->paragraph(),
                    ]);
                }
            }
        }
    }
}