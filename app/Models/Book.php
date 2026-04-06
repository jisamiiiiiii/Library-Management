<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'isbn', 'category_id', 'status'];

   
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class);
    }
}