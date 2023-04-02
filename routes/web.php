<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TweetsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [UsersController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('tweets')->group(function () {
    Route::get('/', [TweetsController::class, 'all'])->middleware(['auth', 'verified'])->name('tweets.all');
    Route::post('/', [TweetsController::class, 'store'])->middleware(['auth', 'verified'])->name('tweets.store');
    Route::get('/{id}', [TweetsController::class, 'show'])->middleware(['auth', 'verified'])->name('tweets.show');
    Route::get('/delete/{id}', [TweetsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('tweets.destroy');
});

Route::prefix('users')->group(function () {
    Route::get('/{username}/tweets', [UsersController::class, 'all'])->middleware(['auth', 'verified'])->name('users.all');
});

Route::fallback(function () { return view("404"); })->name('error');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
