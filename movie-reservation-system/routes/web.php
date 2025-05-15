<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\ShowtimeController as AdminShowtimeController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

// Public routes
Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/showtimes', [MovieController::class, 'showtimes'])->name('movies.showtimes');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('movies', AdminMovieController::class)->except(['show']);
    Route::resource('showtimes', AdminShowtimeController::class);
    Route::get('reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
});

require __DIR__.'/auth.php';
