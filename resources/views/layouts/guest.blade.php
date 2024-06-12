<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>購衣網站</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
        @php
            $currentRoute = request()->route()->getName();
        @endphp
        @if($currentRoute == 'register' || $currentRoute == 'login')
            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                @if($currentRoute == 'register')
                    <h1 class = "font-serif text-4xl text-gray-500 font-bold">會員註冊</h1>
                @endif

                @if($currentRoute == 'login')
                    <h1 class = "font-serif text-4xl text-gray-500 font-bold">會員登入</h1>
                @endif
                
                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        @else
            @include('layouts.GuestNavigation')

             <!-- Page Heading -->
             @if (isset ($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @if (!empty($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        @endif
    </body>
</html>
