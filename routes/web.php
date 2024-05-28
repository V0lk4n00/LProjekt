<?php

use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
use App\Http\Controllers\AudioConversionController;

// All listings
Route::get('/', [ListingController::class, 'index']);

// Single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Audio transcoding
Route::get('/convert', [AudioConversionController::class, 'showConversionForm'])->name('convert.form');
Route::post('/convert', [AudioConversionController::class, 'upload'])->name('convert');
Route::get('/convert/download/{filename}', [AudioConversionController::class, 'download'])->name('download');
