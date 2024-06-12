<?php

namespace App\Http\Controllers;

use FFMpeg\Format\Audio\Mp3;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

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

        // Trigger conversion
        $jsonResponse = $this->convert();

        // Initialize session, attach file path
        Session::flash('converted_file_path', $jsonResponse->original['converted_file_path']);

        // Redirect and download the file
        return redirect()->route('download', ['filename' => basename($jsonResponse->original['converted_file_path'])]);
    }

    // Download function
    public function download($filename): \Illuminate\Http\Response
    {
        $path = storage_path('app/'.$filename);

        // Check if a path (and by extension the file) exists
        if (! file_exists($path)) {
            abort(404);
        }

        // Get contents of a file
        $fileContent = file_get_contents($path);

        // Prepare the headers
        $headers =
            [
                'Content-Type' => mime_content_type($path),
                'Content-Disposition' => 'attachment; filename='.$filename.'"',
            ];

        // Create the response
        $response = Response::make($fileContent, 200, $headers);

        // Delete the file after converting
        register_shutdown_function(function () use ($path) {
            unlink($path);
        });

        return $response;
    }

    // Transcoding function
    private function convert(): JsonResponse
    {
        // Generate a unique filename with MP3 suffix
        $convertedFileName = uniqid('converted_').'.mp3';

        // Convert FLAC to MP3 with custom parameters
        FFMpeg::fromDisk('local')
            ->open('audio/input.flac')
            ->export()
            ->toDisk('local')
            ->inFormat((new Mp3)->setAudioCodec('libmp3lame'))
            ->addFilter(['-max_alloc', '67108864'])
            ->save($convertedFileName);

        // Get the path of the converted file
        $convertedFilePath = Storage::disk('local')->path($convertedFileName);

        // Return a response with the path and a message
        return response()->json([
            'converted_file_path' => $convertedFilePath,
        ]);
    }
}
