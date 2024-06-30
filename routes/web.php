<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\OrderController::class, 'userOrderStats'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::resource('orders', OrderController::class);
    Route::get('/user-order-stats', [OrderController::class, 'userOrderStats'])->name('user.order.stats');
});

require __DIR__.'/auth.php';



