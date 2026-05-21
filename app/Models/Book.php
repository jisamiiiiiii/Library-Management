<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'isbn',
        'title',
        'author',
        'category_id', 
        'status',
        'description',   
        'cover_image',    
        'location',     
        'department',    
    ];

    /**
     * Get the category that the book belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the borrowing history for the book.
     * Automatically sorted by most recent.
     */
    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class)->latest();
    }
}