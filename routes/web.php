<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('panel.pages.dashboard');
    })->name('dashboard');
    Route::get('/house-detail', [HomeController::class, 'house_detail'])->name('house-detail');
    Route::get('/add-house', function () {
        return view('panel.pages.add_house');
    })->name('add-house');
    Route::post('/add-house', [HomeController::class, 'store']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
