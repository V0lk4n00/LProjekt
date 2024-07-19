<?php

namespace App\Http\Controllers;

use FFMpeg\Format\Audio\Mp3;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AudioConversionController extends Controller
{
    // Show conversion form
    public function showConversionForm(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('convert');
    }

    // Upload function
    public function upload(Request $request): RedirectResponse
    {
        // Validation
        $request->validate([
            'audio_file' => 'required|file|mimes:flac',
        ]);

        // Move the file to storage
        $request->file('audio_file')->storeAs('audio', 'input.flac');

        // Redirect with message
        return redirect()->route('convert')->with('message', 'File uploaded successfully!');
    }

    // Transcoding function
    public function transcode(): RedirectResponse
    {
        $path = storage_path('app/audio/input.flac');

        // Check if a path (and by extension the file) exists
        if (! file_exists($path)) {
            return redirect()->route('convert')->with('message', 'File not found!');
        }

        // Generate a unique filename with MP3 suffix
        $name = 'output.mp3';

        // Convert FLAC to MP3 with custom parameters
        FFMpeg::fromDisk('local')
            ->open('audio/input.flac')
            ->export()
            ->toDisk('local')
            ->inFormat(new Mp3)
            ->save($name);

        return redirect()->route('convert')->with('message', 'File transcoded successfully!');
    }

    // Download function
    public function download(): BinaryFileResponse|RedirectResponse
    {
        $path = storage_path('app/output.mp3');

        // Check if a path (and by extension the file) exists
        if (file_exists($path)) {

            // Return the file as a download response
            return response()->download($path)->deleteFileAfterSend();
        }

        // Handle file not found case
        return redirect()->back()->with('message', 'File not found!');
    }
}
