<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Audio Conversion</title>
    </head>

    <body>
        <h1>
            Audio Conversion
        </h1>

        <!-- Upload form -->
        <form action="{{ route('convert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label
                for="audio_file">Select FLAC file to upload:
            </label>
            <input type="file" name="audio_file" id="audio_file" accept=".flac">
            <button type="submit">Convert to MP3</button>
        </form>

        <br>

        <!-- Flash message -->
        @if(Session::has('conversion_response'))
            <div class="alert alert-success">
                {{ Session::get('conversion_response')->original['message'] }}
            </div>
        @endif

        <!-- Download link -->
        @if(Session::has('converted_file_path'))
            <p>Download the converted file: <a href="{{ route('download', ['filename' => Session::get('converted_file_path')]) }}">Download</a></p>
        @endif
    </body>
</html>
