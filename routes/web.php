<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\SubscriptionPackageController;
use App\Http\Controllers\SubscriptionPackageBookController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Middleware\IsloggedIn;

// ngambil data dari data base = user contoller
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/search', [UserController::class, 'search'])->name('search');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/category/{id}', [BookCategoryController::class, 'show'])->name('category.show');
Route::get('/subscription-packages/{id}/detail', [SubscriptionPackageBookController::class, 'showUserDetail'])
    ->name('subscription-package-books.detail');


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
        // Route::get('/dashboard', function () {
        //     return view('admin.dashboard');
        // })->name('dashboard');

        // diganti jadi seperti yang di bawah 

        Route::get('/dashboard', function () {
            return view('admin.dashboard', [
                'totalBooks' => \App\Models\Book::count(),
                'totalCategories' => \App\Models\BookCategory::count(),
                'totalSubscriptions' => \App\Models\SubscriptionPackage::count(),
                'freeBooksCount' => \App\Models\Book::where('price', 0)->count(),
                'recentBooks' => \App\Models\Book::with('bookCategory')->latest()->take(5)->get(),
            ]);
        })->name('dashboard');

        Route::get('book-categories/export', [BookCategoryController::class, 'export'])->name('book-categories.export');
        Route::get('books/export', [BookController::class, 'export'])->name('books.export');
        Route::get('subscriptions/export', [SubscriptionPackageController::class, 'export'])->name('subscriptions.export');

        // package books : memilih paket langganan
        // {} path dinamis = lebih spesifik
        Route::get('/subscription-packages/{id}/books', [SubscriptionPackageBookController::class, 'index'])
            ->name('subscription-packages.books');
        Route::post('/subscription-packages/{id}/books', [SubscriptionPackageBookController::class, 'store'])
            ->name('subscription-packages.books.store');

        // book category controller
        Route::resource('book-categories', BookCategoryController::class);
        // subscription controller
        Route::resource('subscriptions', SubscriptionPackageController::class);
        Route::resource('books', BookController::class);
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    // Checkout halaman (GET)
    Route::get('/subscription-packages/{id}/checkout', [SubscriptionPackageController::class, 'checkoutPage'])
        ->name('subscription.checkout.page');

    // Proses Checkout (POST)
    Route::post('/subscription-packages/{id}/checkout', [SubscriptionPackageController::class, 'checkout'])
        ->name('subscription.checkout');
    Route::prefix('admin')->name('admin.')->group(function () {});

    // Keranjang belanja 
    Route::get('/carts', [CartController::class, 'index'])->name('carts');
    Route::post('/carts', [CartController::class, 'store'])->name('carts.store');
    Route::delete('/carts/{cart}', [CartController::class, 'destroy'])->name('carts.destroy');




    // Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    // Route::post('/profile/photo', [UserController::class, 'updatePhoto'])->name('user.profile.photo');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile/photo', [UserController::class, 'updatePhoto'])->name('user.profile.photo');
});
// patch update salah satu data
// put update seluruh data = tidak error
