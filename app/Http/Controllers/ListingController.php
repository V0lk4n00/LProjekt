<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all listings
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('listings.index',
            [
                // Filtering by tags
                'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
            ]
        );
    }

    // Show single listing
    public function show(Listing $listing): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('listings.show',
            [
                'listing' => $listing
            ]
        );
    }

    // Show create form
    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('listings.create');
    }

    // Store listing
    public function store(Request $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $form = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo'))
        {
            $form['logo'] = $request->file('logo')->store('images', 'public');
        }

        Listing::create($form);

        return redirect('/')->with('message', 'Listing created!');
    }

    // Show edit form
    public function edit(Listing $listing): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update listing
    public function update(Request $request, Listing $listing): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $form = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo'))
        {
            $form['logo'] = $request->file('logo')->store('images', 'public');
        }

        $listing->update($form);

        return redirect('/listings/'.$listing->id)->with('message', 'Listing updated!');
    }

    // Delete listing
    public function delete(Listing $listing): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted!');
    }
}
