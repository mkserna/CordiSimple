<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Event Routes
        Route::get('events', [EventController::class, 'index'])->name('events.index');
        Route::get('events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::get('events/{id}', [EventController::class, 'show'])->name('events.show');
        Route::get('events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('events/{id}', [EventController::class, 'update'])->name('events.update');
        Route::delete('events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
        
    
        // Reservation Routes
        Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/create/{event_id}', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
        Route::get('reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
        Route::put('reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::delete('reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
});

require __DIR__.'/auth.php';
