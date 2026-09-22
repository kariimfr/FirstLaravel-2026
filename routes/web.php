<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/Login', function () {
    return view('login');
})->name('login');
// patch update salah satu data
// put update seluruh data = tidak error