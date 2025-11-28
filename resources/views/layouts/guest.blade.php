<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8">
                <a href="/" class="flex items-center space-x-3 group" wire:navigate>
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-600 to-primary-400 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-primary-500/30 transition-all duration-300">
                        <span class="text-white font-bold text-2xl">L</span>
                    </div>
                    <span class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300">LearnHub</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white dark:bg-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 sm:rounded-3xl transition-all duration-300">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} LearnHub LMS. All rights reserved.
            </div>
        </div>
    </body>
</html>
