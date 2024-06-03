<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Create a new entry
            </h2>
            <p class="mb-4">Add new listing to the database</p>
        </header>

        <form method="POST" action="/listings/store" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label for="company" class="inline-block text-lg mb-2">
                    Label Name
                </label>
                <label>
                    <input
                        type="text"
                        class="border border-gray-400 rounded p-2 w-full"
                        name="company"
                        placeholder="Example: Essential Recordings"
                        value="{{old('company')}}"
                    />
                </label>

                @error('company')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="title" class="inline-block text-lg mb-2">
                    Title
                </label>
                <label>
                    <input
                        type="text"
                        class="border border-gray-400 rounded p-2 w-full"
                        name="title"
                        placeholder="Example: Chicane - Saltwater"
                        value="{{old('title')}}"
                    />
                </label>

                @error('title')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="location" class="inline-block text-lg mb-2">
                    Country
                </label>
                <label>
                    <input
                        type="text"
                        class="border border-gray-400 rounded p-2 w-full"
                        name="location"
                        placeholder="Example: UK"
                        value="{{old('location')}}"
                    />
                </label>

                @error('location')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="tags" class="inline-block text-lg mb-2">
                    Tags (Comma Separated)
                </label>
                <label>
                    <input
                        type="text"
                        class="border border-gray-400 rounded p-2 w-full"
                        name="tags"
                        placeholder="Example: Trance,1999,UK,Chicane"
                        value="{{old('tags')}}"
                    />
                </label>

                @error('tags')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="logo" class="inline-block text-lg mb-2">
                    Image
                </label>
                <input
                    type="file"
                    class="border border-gray-400 rounded p-2 w-full"
                    name="logo"
                    accept=".jpg, .png, .jpeg, .svg"
                />

                @error('logo')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="inline-block text-lg mb-2">
                    Description
                </label>
                <label>
                    <textarea
                        class="border border-gray-400 rounded p-2 w-full"
                        name="description"
                        rows="10"
                        placeholder="Include tasks, requirements, salary, etc">{{old('description')}}</textarea>
                </label>

                @error('description')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="sample" class="inline-block text-lg mb-2">
                    Audio Sample
                </label>
                <input
                    type="file"
                    class="border border-gray-400 rounded p-2 w-full"
                    name="sample"
                    accept=".flac"
                />

                @error('sample')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    Create listing
                </button>

                <a href="/" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>
