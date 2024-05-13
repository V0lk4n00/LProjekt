<?php

use Illuminate\Support\Facades\Route;
use App\Models\Listing;
use App\Http\Controllers\AudioConversionController;

// All listings
Route::get('/', function ()
{
    return view('listings',
        [
            'heading' => 'Latest listings',
            'listings' => Listing::all()
        ]);
});

// Single listing
Route::get('/listings/{listing}', function (Listing $listing)
{
    return view('listing',
        [
            'listing' => $listing
        ]
    );
});

// Audio conversion
Route::get('/convert', [AudioConversionController::class, 'showConversionForm'])->name('convert.form');
Route::post('/convert', [AudioConversionController::class, 'upload'])->name('convert');
