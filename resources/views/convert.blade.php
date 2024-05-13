<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Audio Conversion</title>
    </head>

    <body>
        <h1>
            Audio Conversion
        </h1>

        <form action="{{ route('convert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label
                for="audio_file">Select FLAC file to upload:
            </label>
            <input type="file" name="audio_file" id="audio_file" accept=".flac">
            <button type="submit">Convert to MP3</button>
        </form>

        <br>

        @if(Session::has('conversion_response'))
            <div class="alert alert-success">
                {{ Session::get('conversion_response')->original['message'] }}
            </div>
        @endif
    </body>
</html>
