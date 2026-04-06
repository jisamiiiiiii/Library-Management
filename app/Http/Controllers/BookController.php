<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                             ->orWhere('author', 'like', "%{$search}%")
                             ->orWhere('isbn', 'like', "%{$search}%")
                             ->orWhereHas('category', function ($q) use ($search) {
                                 $q->where('category_name', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->get();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:available,borrowed,lost,unavailable',
        ]);

        Book::create($validated);
        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:available,borrowed,lost,unavailable',
        ]);

        $book->update($validated);
        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {

        if ($book->status === 'borrowed' || $book->status === 'unavailable') {
            return redirect()->back()->with('error', 'Cannot delete a book that is currently out or unavailable.');
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}