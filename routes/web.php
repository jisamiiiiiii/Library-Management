<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowController; 
use App\Models\Book;      
use App\Models\User;  
use App\Models\Category;  
use App\Models\Borrow; 
use Illuminate\Support\Facades\Route;

// --- GUEST ACCESSIBLE ROUTES ---
Route::get('/', function () {
    return view('welcome');
});


Route::get('/books', [BookController::class, 'index'])->name('books.index');

// --- DASHBOARD ROUTE ---
Route::get('/dashboard', function () {
    $stats = [
        'total_books'      => Book::count(),
        'total_users'      => User::where('role', 'Student')->count(), 
        'categories'       => Category::count(),                      
        'available'        => Book::where('status', 'available')->count(), 
        'pending_requests' => Borrow::where('status', 'pending')->count(), 
    ];

    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

// --- SHARED AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * Module 4: Student View
     */
    Route::get('/my-borrows', [BorrowController::class, 'index'])->name('borrows.index');
    Route::post('/borrows', [BorrowController::class, 'store'])->name('borrows.store'); 
});

// --- LIBRARIAN & STAFF CONTROL ---
Route::middleware(['auth'])->group(function () {
    
    /**
     * Module 2: Book Management
     */
    Route::resource('books', BookController::class)->except(['index']);

    /**
     * Module 4: Admin/Librarian Borrow Management
     * UPDATED: Name changed to admin.borrows.index to fix the 500 error
     */
    Route::get('/admin/borrows', [BorrowController::class, 'allBorrows'])
        ->name('admin.borrows.index'); 
    
    // We keep this as an alias just in case other parts of your UI use it
    Route::get('/admin/borrows-list', [BorrowController::class, 'allBorrows'])
        ->name('admin.borrows'); 
    
    Route::patch('/borrows/{borrow}', [BorrowController::class, 'update'])->name('borrows.update');
    Route::patch('/borrows/{borrow}/return', [BorrowController::class, 'returnBook'])->name('borrows.return');
});

// --- ADMIN-ONLY (USER MANAGEMENT) ---
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';