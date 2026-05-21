<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowController; 
use App\Http\Controllers\DashboardController; // Added this
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
return redirect('/products');
});
// --- GUEST ACCESSIBLE ROUTES ---
Route::get('/', function () {
    return redirect()->route('login');
});

// Accessible by everyone (Guest and Auth)
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// --- DASHBOARD ROUTE ---
// Professional Logic: Logic moved to DashboardController@index
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- SHARED AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * Module: Borrowing System (Student & Staff Shared)
     * Logic: index() handles role-based filtering automatically.
     */
    Route::get('/borrows', [BorrowController::class, 'index'])->name('borrows.index');
    
    // Requesting a book (Student Action)
    Route::post('/borrows/store', [BorrowController::class, 'store'])->name('borrows.store'); 
});

// --- LIBRARIAN & STAFF CONTROL ---
Route::middleware(['auth'])->group(function () {
    
    /**
     * Module: Book Management
     * Logic: Full CRUD for books (Admin side)
     */
    Route::resource('books', BookController::class)->except(['index']);

    /**
     * Module: Borrow Management (Administrative Actions)
     * Logic: These trigger the date-logging we just set up.
     */
    
    // Logic: Librarian approves hand-off (sets borrow_date)
    Route::patch('/borrows/{borrow}/approve', [BorrowController::class, 'update'])->name('borrows.update');
    
    // Logic: Librarian processes return (sets returned_at)
    Route::patch('/borrows/{borrow}/return', [BorrowController::class, 'returnBook'])->name('borrows.return');
    
    /**
     * Module: User & Account Management
     * Logic: Manage Staff and Students
     */
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';