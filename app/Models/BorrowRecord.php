<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BorrowRecord extends Model
{
    protected $fillable = [
        'user_id', 
        'book_id', 
        'librarian_id', 
        'borrow_date', 
        'due_date', 
        'returned_at', // Added for tracking the actual return date
        'status'
    ];

    /**
     * The attributes that should be cast.
     * This allows us to use Carbon methods for professional date formatting.
     */
    protected $casts = [
        'borrow_date' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Relationship: The student (User) who borrowed the book.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: The staff/librarian who processed the transaction.
     */
    public function librarian(): BelongsTo
    {
        return $this->belongsTo(User::class, 'librarian_id');
    }

    /**
     * Relationship: The specific book being borrowed.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Relationship: Links to a return record if you use a separate table for fines/details.
     */
    public function returnRecord(): HasOne
    {
        return $this->hasOne(ReturnRecord::class, 'borrow_id');
    }
}