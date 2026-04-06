<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnRecord extends Model
{
    protected $fillable = [
        'borrow_id', 
        'return_date', 
        'penalty_amount', 
        'status'
    ];

    /** Relationship: A Return Record belongs to one BORROW RECORD */
    public function borrowRecord(): BelongsTo
    {
        return $this->belongsTo(BorrowRecord::class, 'borrow_id');
    }
}