<?php

use App\Http\Controllers\AudioConversionController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Listings
// All listings
Route::get('/', [ListingController::class, 'index'])->name('home');

// Create listing
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// Store listing
Route::post('/listings/store', [ListingController::class, 'store'])->middleware('auth');

// Edit listing
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'delete'])->middleware('auth');

// Manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// Single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// If user were to type in URL "localhost/listings" without any ID or anything else - redirect them back to homepage
Route::get('/listings', function () {
    return redirect('/');
});

// User registration form
Route::get('/register', [UserController::class, 'register'])->middleware('guest');

// Create user
Route::post('/users', [UserController::class, 'create']);

// User login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Authenticate
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// Logout
Route::post('/logout', [UserController::class, 'logout']);

// Audio transcoding
// Show upload form
Route::get('/convert', [AudioConversionController::class, 'showConversionForm'])->name('convert');

// Upload raw file
Route::post('/convert', [AudioConversionController::class, 'upload'])->name('upload');

// Download converted file
Route::get('/convert/download/{filename}', [AudioConversionController::class, 'download'])->name('download');
