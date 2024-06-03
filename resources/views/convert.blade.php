<x-layout>
    @include('partials._search')
    <a href="/" class="inline-block text-black ml-4 mb-4">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h1 class="text-3xl px-2">
                Audio Conversion
            </h1>
        </header>

        <ul class="mt-4 mb-4 list-disc list-inside">
            <li class="mb-2">
                Choose an audio file, then click "Convert to MP3" to upload it.
            </li>
            <li class="mb-2">
                Only audio files in FLAC format are allowed.
            </li>
            <li class="mb-2">
                The file cannot be bigger than 300MB.
            </li>
            <li class="mb-2">
                If the upload is successful, download will start automatically.
            </li>
            <li class="mb-2">
                Output file will be in MP3 format, 128 kb/s bitrate.
            </li>
        </ul>

        <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="audio_file" class="inline-block">
                    Select FLAC file to upload:
                </label>
                <input type="file" name="audio_file" id="audio_file" accept=".flac" class="border border-gray-200 rounded p-2 w-full">
            </div>

            <div>
                <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-slate-800" type="submit">
                    Convert to MP3
                </button>
            </div>
        </form>
    </x-card>
</x-layout>
