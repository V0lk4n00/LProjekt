<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListingController extends Controller
{
    // Show all listings
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('listings.index',
            [
                // Filtering by tags
                'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6),
            ]
        );
    }

    // Show single listing
    public function show(Listing $listing): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('listings.show',
            [
                'listing' => $listing,
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
            'tags' => 'required',
            'company' => '',
            'location' => '',
            'description' => '',
        ]);

        if ($request->hasFile('logo')) {
            $form['logo'] = $request->file('logo')->store('images', 'public');
        }

        if ($request->hasFile('sample')) {
            $form['sample'] = $request->file('sample')->store('audio');
        }

        $form['user_id'] = auth()->id();

        Listing::create($form);

        return redirect()->route('home')->with('message', 'Listing created!');
    }

    // Show edit form
    public function edit(Listing $listing): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update listing
    public function update(Request $request, Listing $listing): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        // Make sure if logged user is the owner of the listing
        $user = auth()->user();

        /** @var User $user */
        if (! $user || $listing->user_id != $user->id) {
            abort(403, 'Unauthorized action');
        }

        $form = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'company' => '',
            'location' => '',
            'description' => '',
        ]);

        if ($request->hasFile('logo')) {
            $form['logo'] = $request->file('logo')->store('images', 'public');
        }

        if ($request->hasFile('sample')) {
            $form['sample'] = $request->file('sample')->store('audio');
        }

        $listing->update($form);

        //return redirect('/listings/'.$listing->id)->with('message', 'Listing updated!');
        return redirect()->route('show', ['listing' => $listing->id])->with('message', 'Listing updated!');
    }

    // Download an audio file associated with the listing
    public function download(Listing $listing): StreamedResponse|RedirectResponse
    {
        // Check if the file exists
        if (! $listing->sample || ! Storage::disk('local')->exists($listing->sample)) {
            return redirect()->back();
        }

        return Storage::disk('local')->download($listing->sample);
    }

    // Delete listing
    public function delete(Listing $listing): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        // Make sure if logged user is the owner of the listing
        $user = auth()->user();

        /** @var User $user */
        if (! $user || $listing->user_id != $user->id) {
            abort(403, 'Unauthorized action');
        }

        $listing->delete();

        return redirect()->route('home')->with('message', 'Listing deleted!');
    }

    // Manage listings
    public function manage(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
