<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-gradient-to-b from-gray-950 via-gray-800/60 to-red-900/70">
    <div class="flex min-h-[80vh] flex-col items-center justify-center">
        <x-app-logo-2 class="h-20 w-20" />
        <div class="rounded-3xl bg-white/30 px-12 py-12 text-center shadow-2xl">
            <h1 class="mb-4 text-4xl font-bold text-neutral-900 dark:text-neutral-100">Welcome to The Archiver</h1>
            <p class="mb-8 text-xl text-neutral-600 dark:text-neutral-400">Your personal digital archiving library.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}" class="rounded-lg bg-red-800/60 px-6 py-3 font-semibold text-white transition-colors hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Login</a>
                <a href="{{ route('register') }}" class="rounded-lg bg-neutral-200 px-6 py-3 font-semibold text-neutral-800 transition-colors hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-neutral-500 focus:ring-offset-2 dark:bg-neutral-700 dark:text-neutral-100 dark:hover:bg-neutral-800">Register</a>
            </div>
        </div>
    </div>
    @fluxScripts
</body>
</html>