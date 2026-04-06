<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowController extends Controller
{
  
    public function index()
    {
    
        $borrows = Borrow::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('borrows.index', compact('borrows'));
    }

    public function allBorrows()
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Librarian'])) {
            abort(403, 'Unauthorized action.');
        }

        $borrows = Borrow::with(['user', 'book'])->latest()->get();
        
        return view('admin.borrows.index', compact('borrows'));
    }

    public function store(Request $request)
    {
        $book = Book::findOrFail($request->book_id);

        if ($book->status !== 'available') {
            return redirect()->back()->with('error', 'Sorry, this book is already out or requested.');
        }

        Borrow::create([
            'user_id'       => Auth::id(),
            'book_id'       => $book->id,
            'borrowed_date' => Carbon::now(),
            'due_date'      => Carbon::now()->addDays(7),
            'status'        => 'pending',
        ]);

        $book->update(['status' => 'borrowed']);

        return redirect()->route('borrows.index')
            ->with('success', 'Your borrow request for "' . $book->title . '" has been sent!');
    }

    public function update(Request $request, Borrow $borrow)
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Librarian'])) {
            abort(403);
        }

        $borrow->update(['status' => 'borrowed']);
        $borrow->book->update(['status' => 'borrowed']);
        
        return redirect()->back()->with('success', 'Request approved!');
    }

    public function returnBook(Borrow $borrow)
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Librarian'])) {
            abort(403);
        }

        $borrow->update([
            'status' => 'returned',
            'returned_at' => Carbon::now() 
        ]);

        $borrow->book->update(['status' => 'available']);

        return redirect()->back()->with('success', 'Book is now available for others!');
    }



    
}