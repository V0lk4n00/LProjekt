<?php

use Illuminate\Support\Facades\Route;
use App\Models\Listing;

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
