<?php

use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AudioConversionController;

// All listings
Route::get('/', [ListingController::class, 'index']);

// Create listing
Route::get('/listings/create', [ListingController::class, 'create']);

// Store listing
Route::post('/listings', [ListingController::class, 'store']);

// Single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Audio transcoding
Route::get('/convert', [AudioConversionController::class, 'showConversionForm'])->name('convert.form');
Route::post('/convert', [AudioConversionController::class, 'upload'])->name('convert');
Route::get('/convert/download/{filename}', [AudioConversionController::class, 'download'])->name('download');
