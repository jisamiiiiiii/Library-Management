<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a listing of the books with Search and Quick Filters.
     */
    public function index(Request $request)
    {
        // 1. Start the query with the category relationship loaded
        $query = Book::with('category');

        // 2. Apply Search logic
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%")
                  ->orWhere('isbn', 'LIKE', "%{$search}%");
            });
        }

        // 3. Apply "Quick Filter" logic
        // Checks if category is numeric (ID) or a string (Name) 
        if ($request->filled('category') && $request->category !== 'All') {
            if (is_numeric($request->category)) {
                $query->where('category_id', $request->category);
            } else {
                $query->whereHas('category', function($q) use ($request) {
                    $q->where('category_name', $request->category);
                });
            }
        }

        // 4. Execute query with pagination (keeping filters in the links)
        $books = $query->latest()->paginate(10)->withQueryString();
        
        // 5. Get all categories for the filter buttons
        $categories = Category::all();
        
        return view('books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'isbn'        => 'required|string|max:20|unique:books,isbn',
            'category_id' => 'required|exists:categories,id',
            'department'  => 'required|string',
            'location'    => 'required|string|max:100',
            'status'      => 'required|in:available,borrowed,lost',
            'summary'     => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'isbn'        => ['required', 'string', 'max:20', Rule::unique('books')->ignore($book->id)],
            'category_id' => 'required|exists:categories,id', 
            'department'  => 'required|string',
            'location'    => 'required|string|max:100',
            'status'      => 'required|in:available,borrowed,lost',
            'summary'     => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old image if it exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book)
    {
        // Check for active borrows before deleting (Recommended logic)
        if ($book->status === 'borrowed') {
            return redirect()->route('books.index')->with('error', 'Cannot delete a book that is currently borrowed.');
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}