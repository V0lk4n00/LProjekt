<x-layout>
    @include('partials._search')
    <a href="/" class="inline-block text-black ml-4 mb-4">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
    <div class="mx-4">
        <x-card class="p-10">
            <div class="flex flex-col items-center justify-center text-center">
                <img class="w-64 mb-6" src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('images/no-image.jpg')}}" alt="" />

                <h3 class="text-2xl mb-2">{{$listing->title}}</h3>
                <div class="text-xl font-bold mb-4">{{$listing->company}}</div>

                <x-listing-tags :tagsCsv="$listing->tags"/>

                <div class="text-lg my-4">
                    <i class="fa-solid fa-location-dot"></i>
                    {{$listing->location}}
                </div>

                <div class="border border-gray-400 w-full mb-6"></div>

                <div>
                    <h3 class="text-3xl font-bold mb-4">
                        Description
                    </h3>
                    <div class="text-lg space-y-6">
                        {{$listing->description}}
                    </div>
                </div>
            </div>
        </x-card>

        <x-card class="mt-4 p-2 flex flex-col items-center space-x-6">
            <form method="POST" action="/listings/{{$listing->id}}/download">
                @csrf
                <button class="align-center text-red-500">
                    <i class="fa-solid fa-download"></i>
                    Download
                </button>
            </form>
        </x-card>
    </div>
</x-layout>
