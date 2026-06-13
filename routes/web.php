<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Route (Frontend)
Route::get('/', [HomeController::class, 'overview']);

// Authenticated Users Group
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard & Property Details

    Route::get('/house-detail', [HomeController::class, 'house_detail'])->name('house-detail');

    // House Module
    Route::get('/add-house', [HomeController::class, 'add_house_view'])->name('add-house');
    Route::post('/add-house', [HomeController::class, 'store']);
    Route::get('/house/{id}', [HomeController::class, 'show'])->name('panel.pages.show');

    // Booking Module
    Route::get('/booking', [HomeController::class, 'showBookingPage'])->name('booking');
    Route::get('/booking-list', [HomeController::class, 'bookingList'])->name('booking.list');
    Route::get('/book-house/{id}', [HomeController::class, 'showBookForm'])->name('book.house');
    Route::post('/book-house', [HomeController::class, 'processBooking'])->name('book.store');
    Route::delete('/booking/delete/{id}', [HomeController::class, 'deleteBooking'])->name('booking.delete');

    // Appointment Module
    Route::post('/book-appointment/{id}', [HomeController::class, 'book_appointment'])->name('book.appointment');
    Route::get('/appointments', [HomeController::class, 'appointmentList'])->name('appointment.list');
    Route::delete('/appointment/delete/{id}', [HomeController::class, 'deleteAppointment'])->name('appointment.delete');

    // Review Module
    Route::get('/review', [HomeController::class, 'review'])->name('review.index');
    Route::post('/review/store', [HomeController::class, 'store_review'])->name('review.store');
    Route::delete('/review/delete/{id}', [HomeController::class, 'delete_review'])->name('review.delete');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chat Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/chat/users', [ChatController::class, 'userList'])->name('chat.users');
        Route::post('/chat/start/{userId}', [ChatController::class, 'startConversation'])->name('chat.start');
        Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{id}/send', [ChatController::class, 'send'])->name('chat.send');
        Route::get('/chat/{id}/fetch', [ChatController::class, 'fetch'])->name('chat.fetch');
    });
    // Admin Only Routes
    Route::middleware('admin')->group(function () {
        // User Management
        Route::get('/dashboard', [HomeController::class, 'summery'])->name('dashboard');
        Route::get('/add-user', function () {
            return view('panel.pages.add_user');
        });
        Route::post('/add-user', [HomeController::class, 'add_user'])->name('add-user');
        Route::get('/user-list', [HomeController::class, 'user_list']);
        Route::get('/edit-user/{id}', [HomeController::class, 'edit_user'])->name('edit-user');
        Route::post('/edit-user/{id}', [HomeController::class, 'update_user'])->name('update-user');
        Route::get('/delete-user/{id}', [HomeController::class, 'delete_user'])->name('delete-user');

        // Property Approval System
        Route::get('/pending-houses', [HomeController::class, 'pending_houses'])->name('admin.pending_houses');
        Route::post('/approve-house/{id}', [HomeController::class, 'approve_house'])->name('admin.approve_house');
        Route::post('/reject-house/{id}', [HomeController::class, 'reject_house'])->name('admin.reject_house');

        // Appointment Actions
        Route::post('/appointment/approve/{id}', [HomeController::class, 'approveAppointment'])->name('appointment.approve');
        Route::post('/appointment/reject/{id}', [HomeController::class, 'rejectAppointment'])->name('appointment.reject');
        Route::get('/add-team-member', function () {
            return view('panel.pages.add_team_member');
        });
        Route::post('/add-team-member', [HomeController::class, 'add_team_member'])->name('add_team_member');
        Route::get('/see-team-members', [HomeController::class, 'see_team_members']);
        Route::get('/edit-team-member/{id}', [HomeController::class, 'edit_team_member'])->name('edit-team-member');
        Route::post('/edit-team-member/{id}', [HomeController::class, 'update_team_member'])->name('update-team-member');
    });
});

require __DIR__ . '/auth.php';
