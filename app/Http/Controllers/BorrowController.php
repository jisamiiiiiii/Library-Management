<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class BorrowController extends Controller
{
    /**
     * Display a listing of borrowing transactions.
     */
    public function index()
    {
        if (in_array(Auth::user()->role, ['Admin', 'Librarian'])) {
            $borrows = Borrow::with(['user', 'book'])->latest()->get();
        } else {
            $borrows = Borrow::with('book')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('borrows.index', compact('borrows'));
    }

    /**
     * Store a new borrow request with strong error trapping.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // lockForUpdate prevents two people from grabbing the last book at the same time
                $book = Book::where('id', $request->book_id)->lockForUpdate()->firstOrFail();
                $user = Auth::user();

                // 1. Limit Check (Max 4 active books)
                $activeBorrowsCount = Borrow::where('user_id', $user->id)
                    ->whereIn('status', ['pending', 'borrowed'])
                    ->count();

                if ($activeBorrowsCount >= 4) {
                    return redirect()->back()->with('error', 'Limit reached! You can only have 4 active books at a time.');
                }

                // 2. Duplicate Check
                $alreadyRequested = Borrow::where('user_id', $user->id)
                    ->where('book_id', $book->id)
                    ->whereIn('status', ['pending', 'borrowed'])
                    ->exists();

                if ($alreadyRequested) {
                    return redirect()->back()->with('error', 'You already have an active request for this specific book.');
                }

                // 3. Availability Check
                if ($book->status !== 'available') {
                    return redirect()->back()->with('error', 'Safety Check: This book was just marked as ' . $book->status . '.');
                }

                // 4. Create record and Update book status (Atomic)
                Borrow::create([
                    'user_id'       => $user->id,
                    'book_id'       => $book->id,
                    'borrowed_date' => Carbon::now(),
                    'due_date'      => Carbon::now()->addDays(7),
                    'status'        => 'pending',
                ]);

                $book->update(['status' => 'borrowed']);

                return redirect()->route('borrows.index')
                    ->with('success', 'Borrow request for "' . $book->title . '" sent for approval!');
            });
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'System Error: Transaction failed. Please try again.');
        }
    }

    /**
     * Approve a borrow request (Admin/Librarian Only).
     */
    public function update(Request $request, Borrow $borrow)
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Librarian'])) {
            abort(403);
        }

        try {
            DB::transaction(function () use ($borrow) {
                $borrow->update(['status' => 'borrowed']);
                $borrow->book->update(['status' => 'borrowed']);
            });

            return redirect()->back()->with('success', 'Request approved!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to approve request.');
        }
    }

    /**
     * Process book return (Admin/Librarian Only).
     */
    public function returnBook(Borrow $borrow)
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Librarian'])) {
            abort(403);
        }

        try {
            DB::transaction(function () use ($borrow) {
                if ($borrow->status === 'returned') {
                    throw new Exception('Book already returned.');
                }

                $borrow->update([
                    'status' => 'returned',
                    'returned_at' => Carbon::now() 
                ]);

                $borrow->book->update(['status' => 'available']);
            });

            return redirect()->back()->with('success', 'Book return processed successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove a transaction log or cancel request.
     */
    public function destroy(Borrow $borrow)
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Librarian'])) {
            if ($borrow->user_id !== Auth::id() || $borrow->status !== 'pending') {
                abort(403);
            }
        }

        try {
            DB::transaction(function () use ($borrow) {
                if ($borrow->status !== 'returned') {
                    $borrow->book->update(['status' => 'available']);
                }
                $borrow->delete();
            });

            return redirect()->back()->with('success', 'Borrow record removed.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete record.');
        }
    }
}