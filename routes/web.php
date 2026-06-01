<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'summery'])->name('dashboard');
    Route::get('/house-detail', [HomeController::class, 'house_detail'])->name('house-detail');

    Route::get('/add-house', function () {
        return view('panel.pages.add_house');
    })->name('add-house');

    Route::post('/add-house', [HomeController::class, 'store']);
    Route::get('/add-house', [HomeController::class, 'add_house_view'])->name('add-house');
    Route::get('/booking', [HomeController::class, 'showBookingPage'])->name('booking');
    Route::get('/book-house/{id}', [HomeController::class, 'showBookForm'])->name('book.house');
    Route::post('/book-house', [HomeController::class, 'processBooking'])->name('book.store');
    Route::get('/house/{id}', [HomeController::class, 'show'])->name('panel.pages.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chat', function () {
        return view('panel.pages.chat');
    })->name('chat');

    Route::middleware('admin')->group(function () {
        Route::get('/add-user', function () {
            return view('panel.pages.add_user');
        });
        Route::post('/add-user', [HomeController::class, 'add_user'])->name('add-user');
        Route::get('/user-list', [HomeController::class, 'user_list']);
    });
});

require __DIR__ . '/auth.php';
