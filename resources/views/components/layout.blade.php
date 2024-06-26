<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            laravel: "#334155",
                        },
                    },
                },
            };
        </script>
        <title>WebPage | The best webpage of them all</title>
    </head>

    <body class="mb-24">
        <nav class="flex justify-between items-center mb-4 bg-slate-200">
            <a href="{{ route('home') }}">
                <img class="w-24 logo" src="{{asset('images/logo.png')}}" alt="logo">
            </a>
            <ul class="flex space-x-6 mr-6 text-lg">
                @auth()
                <li>
                    <span class="font-bold uppercase">
                        Welcome, {{Auth::user()->name}}
                    </span>
                </li>

                <li>
                    <a href="{{ route('manage') }}" class="hover:text-laravel">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        Manage music
                    </a>
                </li>

                <li>
                    <form class="inline" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-door-closed"></i>
                            Log out
                        </button>
                    </form>
                </li>

                @else
                <li>
                    <a href="{{ route('register') }}" class="hover:text-laravel">
                        <i class="fa-solid fa-user-plus"></i>
                        Register
                    </a>
                </li>

                <li>
                    <a href="{{ route('login') }}" class="hover:text-laravel">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        Login
                    </a>
                </li>
                @endauth
            </ul>
        </nav>

        <main>
            {{$slot}}
        </main>

        <footer
            class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-white h-20 mt-20 opacity-80 md:justify-center">
            <p class="ml-2">Copyright &copy; 2024, All Rights reserved</p>

            <a href="{{ route('create') }}" class="absolute center right-10 rounded bg-slate-900 hover:bg-black text-white py-2 px-5">
                Add new song
            </a>
        </footer>

        <x-flash-messages />
    </body>
</html>
