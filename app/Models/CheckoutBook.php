<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

#[Fillable(['checkout_id', 'book_id', 'total_book'])]
class Checkout extends Model
{
    public function Checkouts(): BelongsTo
    {
        return $this->belongsTo(Checkout::class);
    }

    public function Books(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
