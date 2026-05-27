<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('panel.pages.dashboard');
    })->name('dashboard');

    Route::get('/house-detail', [HomeController::class, 'house_detail'])->name('house-detail');
    Route::get('/add-house', function () { return view('panel.pages.add_house'); })->name('add-house');
    Route::post('/add-user', [HomeController::class, 'add_user'])->name('add-user');

    
    Route::get('/add-user', function () {
        return view('panel.pages.add_user');
    });

    Route::get('/booking', [HomeController::class, 'showBookingPage'])->name('booking');
    Route::post('/add-house', [HomeController::class, 'store']);
    Route::get('/user-list', [HomeController::class, 'user_list']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/book-house/{id}', [HomeController::class, 'showBookForm'])->name('book.house');
    Route::post('/book-house', [HomeController::class, 'processBooking'])->name('book.store');

    Route::get('/house/{id}', [HouseController::class, 'show'])->name('panel.pages.show');
});

require __DIR__ . '/auth.php';