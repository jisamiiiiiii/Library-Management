<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'status',      // pending, borrowed, returned
        'due_date',
        'returned_at', 
    ];

    protected $casts = [
        'due_date'      => 'datetime',
        'returned_at'   => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function isOverdue(): bool
    {
        if ($this->status === 'borrowed' && $this->due_date) {
            return Carbon::now()->greaterThan($this->due_date);
        }
        return false;
    }

    public function daysRemaining(): int
    {
        if ($this->status === 'borrowed' && $this->due_date) {
            return (int) Carbon::now()->diffInDays($this->due_date, false);
        }
        return 0;
    }
}