<?php
use App\Http\Controllers\ChatController;
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
    Route::get('/booking-list', [HomeController::class, 'bookingList'])->name('booking.list');
    Route::get('/book-house/{id}', [HomeController::class, 'showBookForm'])->name('book.house');
    Route::post('/book-house', [HomeController::class, 'processBooking'])->name('book.store');
    Route::get('/house/{id}', [HomeController::class, 'show'])->name('panel.pages.show');
    Route::post('/book-appointment/{id}', [HomeController::class, 'book_appointment'])->name('book.appointment');
    Route::delete('/appointment/delete/{id}', [HomeController::class, 'deleteAppointment'])->name('appointment.delete');
    Route::delete('/booking/delete/{id}', [HomeController::class, 'deleteBooking'])->name('booking.delete');
    Route::get('/appointments', [HomeController::class, 'appointmentList'])->name('appointment.list');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chat Routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/start', [ChatController::class, 'startConversation'])->name('chat.start');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{id}/fetch', [ChatController::class, 'fetch'])->name('chat.fetch');

    Route::get('/review', function () {
        return view('panel.pages.review');
    })->name('review');
    Route::get('/review', [App\Http\Controllers\HomeController::class, 'review'])->name('review.index');
    Route::post('/review/store', [App\Http\Controllers\HomeController::class, 'store_review'])->name('review.store');
    Route::delete('/review/delete/{id}', [App\Http\Controllers\HomeController::class, 'delete_review'])->name('review.delete');
    Route::middleware('admin')->group(function () {
        Route::get('/add-user', function () {
            return view('panel.pages.add_user');
        });
        Route::post('/add-user', [HomeController::class, 'add_user'])->name('add-user');
        Route::get('/user-list', [HomeController::class, 'user_list']);
        Route::get('/edit-user/{id}', [HomeController::class, 'edit_user'])->name('edit-user');
        Route::post('/edit-user/{id}', [HomeController::class, 'update_user'])->name('update-user');
        Route::get('/delete-user/{id}', [HomeController::class, 'delete_user'])->name('delete-user');
        Route::get('/pending-houses', [HomeController::class, 'pending_houses'])->name('admin.pending_houses');
        Route::post('/approve-house/{id}', [HomeController::class, 'approve_house'])->name('admin.approve_house');
        Route::post('/reject-house/{id}', [HomeController::class, 'reject_house'])->name('admin.reject_house');
        Route::post('/appointment/approve/{id}', [HomeController::class, 'approveAppointment'])->name('appointment.approve');
        Route::post('/appointment/reject/{id}', [HomeController::class, 'rejectAppointment'])->name('appointment.reject');
    });
});

require __DIR__ . '/auth.php';
