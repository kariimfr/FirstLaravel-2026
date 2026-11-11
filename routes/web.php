<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\SubscriptionPackageController;
use App\Http\Controllers\SubscriptionPackageBookController;
use App\Http\Controllers\BookController;
// ngambil data dari data base = user contoller
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/search', [UserController::class, 'search'])->name('search');
Route::get('/category/{id}', [BookCategoryController::class, 'show'])->name('category.show');

Route::middleware(['IsGuest'])->group(function () {
    Route::get('/login', function () {
        return view('login'); // sesuaikan dengan nama file view 
    })->name('login');

    Route::post('/login', [UserController::class, 'login'])->name('login.store');

    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::post('/register', [UserController::class, 'register'])->name('register.store');
});

Route::middleware(['IsLoggedIn'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->middleware(['is.admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // package books : memilih paket langganan
        // {} path dinamis = lebih spesifik
        Route::get('/subscription-packages/{id}/books', [SubscriptionPackageBookController::class, 'index'])
            ->name('subscription-packages.books');
        Route::post('/subscription/{id}/books', [SubscriptionPackageBookController::class, 'store'])
            ->name('subscription-packages.books.store');

        // book category controller
        Route::resource('book-categories', BookCategoryController::class);
        // subscription controller
        Route::resource('subscriptions', SubscriptionPackageController::class);
        Route::resource('books', BookController::class);
    });
});

// patch update salah satu data
// put update seluruh data = tidak error
