<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Audio Conversion</title>
    </head>

    <body>
        <h1>
            Audio Conversion
        </h1>

        <p>
            Only audio files in FLAC format allowed. The file cannot be bigger than 300MB.
        </p>

        <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label
                for="audio_file">Select FLAC file to upload:
            </label>
            <input type="file" name="audio_file" id="audio_file" accept=".flac">
            <button type="submit">Convert to MP3</button>
        </form>
    </body>
</html>
