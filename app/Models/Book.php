<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'cover',
    'title',
    'price',
    'description',
    'language',
    'publisher',
    'weitter',
    'realese_date',
    'page_of_book',
    'book_category_id'
])]
class Book extends Model
{
    public function bookCategory()
    {
        return $this->belongsTo(bookCategory::class);
    }

    public function checkoutBooks(): HasMany
    {
        return $this->hasmany(checkoutBook::class);
    }

    public function subscriptonPackageBooks(): HasMany
    {
        return $this->hasmany(subscriptionPackageBook::class);
    }
}
