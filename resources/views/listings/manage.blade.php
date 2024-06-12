<x-layout>
    <x-card>
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                Manage Music
            </h1>
        </header>

        <table class="w-full table-auto rounded-sm">
            <tbody>
            @unless($listings->isEmpty())
                @foreach($listings as $listing)
                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-teal-800 text-lg">
                        <a href="{{ route('home') }}/listings/{{$listing->id}}">
                            {{$listing->title}}
                        </a>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-teal-800 text-lg">
                        <a href="{{ route('home') }}/listings/{{$listing->id}}/edit" class="text-blue-800 px-6 py-2 rounded-xl">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Edit
                        </a>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-teal-800 text-lg">
                        <form method="POST" action="{{ route('home') }}/listings/{{$listing->id}}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-700">
                                <i class="fa-solid fa-trash"></i>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @else
                <tr class="border-grey-300">
                    <td class="px-4 py-8 border-t border-b border-gray-300">
                        <p class="text-center">
                            No listings found
                        </p>
                    </td>
                </tr>
            @endunless
            </tbody>
        </table>
    </x-card>
</x-layout>
