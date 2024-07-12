<?php

use App\Http\Controllers\AudioConversionController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Listings
// All listings
Route::get('/', [ListingController::class, 'index'])->name('home');

// Create listing
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth')->name('create');

// Store listing
Route::post('/listings/store', [ListingController::class, 'store'])->middleware('auth')->name('store');

// Edit listing
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Download audio sample
Route::post('/listings/{listing}/download', [ListingController::class, 'download'])->middleware('auth');

// Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'delete'])->middleware('auth');

// Manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth')->name('manage');

// Single listing
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('show');

// If user were to type in URL "localhost/listings" without any ID or anything else - redirect them back to homepage
Route::get('/listings', function () {
    return redirect('/');
});


// Users
// User registration form
Route::get('/register', [UserController::class, 'register'])->middleware('guest')->name('register');

// Create user
Route::post('/users', [UserController::class, 'create'])->name('new_user');

// User login form
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');

// Authenticate
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->name('authenticate');

// Logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');


// Audio transcoding
// Show upload form
Route::get('/convert', [AudioConversionController::class, 'showConversionForm'])->name('convert');

// Upload raw file
Route::post('/convert/upload', [AudioConversionController::class, 'upload'])->name('upload');

// Transcode the file
Route::post('/convert/transcode', [AudioConversionController::class, 'transcode'])->name('transcode');

// Download converted file
Route::get('/convert/download', [AudioConversionController::class, 'download'])->name('download');
