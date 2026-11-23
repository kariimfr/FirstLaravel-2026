<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['subscription_package_id', 'book_id'])]
class SubscriptionPackageBook extends Model
{
    protected $table = 'subscriptions_packages_books';

    // public function subscriptionPackageBooks()
    // {
    //     return $this->hasMany(SubscriptionPackageBook::class, 'subscription_package_id');
    // }

    public function subscriptionPackage(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPackage::class, 'subscription_package_id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(book::class);
    }

    public function show($id)
    {
        $book = Book::where('id', $id)->with('subscriptionPackageBooks')->first();
        return view('user.books.show', compact('book'));
    }
}
