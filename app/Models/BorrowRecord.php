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
        'status'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function librarian(): BelongsTo
    {
        return $this->belongsTo(User::class, 'librarian_id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function returnRecord(): HasOne
    {
        return $this->hasOne(ReturnRecord::class, 'borrow_id');
    }
}