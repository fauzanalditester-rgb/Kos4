<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'SewaVIP Admin') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; letter-spacing: -0.01em; }
    </style>
</head>
<body class="h-full antialiased font-sans text-[#333333] selection:bg-[#FFCC00] selection:text-[#333333] bg-[#FAFAFA]">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <a href="/" wire:navigate class="flex flex-col items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-[#333333] rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-8 h-8 text-[#FFCC00]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-3xl font-extrabold tracking-tight text-[#333333]">Sewa<span class="text-[#FFCC00] font-medium">VIP.</span></span>
        </a>

        <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl border border-slate-100 relative">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
