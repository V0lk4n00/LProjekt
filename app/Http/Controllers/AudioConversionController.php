<?php

namespace App\Http\Controllers;

use FFMpeg\Format\Audio\Mp3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Storage;

class AudioConversionController extends Controller
{
    public function showConversionForm()
    {
        return view('convert');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'audio_file' => 'required|file|mimes:flac',
        ]);

        // Move uploaded file to 'audio' directory and rename it to 'input.flac'
        $path = $request->file('audio_file')->storeAs('audio', 'input.flac');

        // Trigger conversion and get JSON response
        $jsonResponse = $this->convert();

        // Set flash message with JSON response
        Session::flash('conversion_response', $jsonResponse);

        // Store the converted file path in the session for downloading
        Session::flash('converted_file_path', $jsonResponse->original['converted_file_path']);

        // Redirect to the download route with the file name
        return redirect()->route('download', ['filename' => basename($jsonResponse->original['converted_file_path'])]);
    }

    public function download($filename)
    {
        $path = storage_path('app/' . $filename);

        if(!file_exists($path))
        {
            abort(404);
        }

        return Response::download($path);
    }

    private function convert()
    {
        // Path to the input FLAC file
        $flacFilePath = ('audio/input.flac');

        // Generate a unique filename for the converted MP3 file
        $convertedFileName = uniqid('converted_') . '.mp3';

        // Convert FLAC to MP3
        FFMpeg::fromDisk('local') // Assuming 'local' disk is configured in filesystems.php
        ->open($flacFilePath)
            ->export()
            ->toDisk('local') // Assuming 'local' disk is configured in filesystems.php
            ->inFormat(new Mp3)
            ->save($convertedFileName);

        // Get the path of the converted file
        $convertedFilePath = Storage::disk('local')->path($convertedFileName);

        // Optionally, you can store the converted file in a different location
        // Storage::disk('converted')->put($convertedFileName, file_get_contents($convertedFilePath));

        // Return a response with the path to the converted file
        return response()->json([
            'message' => 'Audio file converted successfully!',
            'converted_file_path' => $convertedFilePath,
        ]);
    }
}
