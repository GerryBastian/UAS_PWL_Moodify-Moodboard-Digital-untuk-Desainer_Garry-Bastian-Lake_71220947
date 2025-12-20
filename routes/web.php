<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\OtpController;
use Illuminate\Support\Facades\Auth;

// landing page
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// OTP routes
Route::get('otp', [OtpController::class, 'showOtpForm'])->name('otp.form');
Route::post('otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Homepage / Dashboard
    Route::get('/home', [MoodboardController::class, 'home'])->name('home');

    // Moodboard Routes (accessible by all authenticated users)
    Route::get('/moodboards', [MoodboardController::class, 'index'])->name('moodboards.index');
    Route::get('/moodboards/create', [MoodboardController::class, 'create'])->name('moodboards.create');
    Route::post('/moodboards', [MoodboardController::class, 'store'])->name('moodboards.store');
    Route::get('/moodboards/{moodboard}', [MoodboardController::class, 'show'])->name('moodboards.show');
    Route::post('/moodboards/{moodboard}/favorite', [MoodboardController::class, 'toggleFavorite'])->name('moodboards.favorite');
    Route::get('/moodboards/{moodboard}/edit', [MoodboardController::class, 'edit'])->name('moodboards.edit');
    Route::put('/moodboards/{moodboard}', [MoodboardController::class, 'update'])->name('moodboards.update');
    Route::delete('/moodboards/{moodboard}', [MoodboardController::class, 'destroy'])->name('moodboards.destroy');

    // User Routes (accessible by all authenticated users)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/addform', [UserController::class, 'create'])->name('users.addform');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/save', [UserController::class, 'store'])->name('users.save');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/delete/{id}', [UserController::class, 'destroyById'])->name('users.delete');
    
    // User Profile Routes (accessible by all authenticated users)
    Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('user.profile.update');
});
