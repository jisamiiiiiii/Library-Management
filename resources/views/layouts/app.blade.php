<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel Library') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Smooth scroll for a premium feel */
            html { scroll-behavior: smooth; }
            /* Custom Scrollbar for the dark theme */
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: #020617; }
            ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
            ::-webkit-scrollbar-thumb:hover { background: #000000; }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#020617] text-slate-200">
        <div class="min-h-screen bg-[#020617]">
            @include('layouts.navigation')

            @isset($header)
    <header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $header }}
    </div>
</header>
@endisset

            <main>
                <div class="animate-fade-in">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                 class="fixed bottom-5 right-5 bg-emerald-600 text-white px-6 py-3 rounded-lg shadow-2xl z-[100] flex items-center space-x-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
    </body>
</html>