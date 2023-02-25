<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Shopping List: @yield('title')</title>

        <!-- Styles -->
        @vite('resources/css/app.css')
    </head>
    <body class="antialiased">
        <div class="sm:flex sm:justify-center sm:items-center min-h-screen bg-gray-100 selection:bg-gray-900 selection:text-white">

            <div class="w-96 shopping-list bg-white p-10 rounded-lg drop-shadow-lg">
                <h1 class="text-2xl text-stone-800">@yield('page_heading')</h1>
                <div class="shopping-list-content text-stone-600">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
