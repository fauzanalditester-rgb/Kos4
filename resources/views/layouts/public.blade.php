<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SewaVIP - Sewa Kamar VIP Eksklusif di Pekanbaru">
    <title>{{ $title ?? 'SewaVIP - Kamar VIP Pekanbaru' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">SewaVIP</span>
                </a>
                <div class="hidden md:flex items-center gap-6">
                    <a href="#hero" class="text-sm font-medium text-gray-600 hover:text-amber-600 transition">Beranda</a>
                    <a href="#calendar" class="text-sm font-medium text-gray-600 hover:text-amber-600 transition">Ketersediaan</a>
                    <a href="#booking" class="text-sm font-medium text-gray-600 hover:text-amber-600 transition">Booking</a>
                    <a href="#comments" class="text-sm font-medium text-gray-600 hover:text-amber-600 transition">Komentar</a>
                    @auth
                        <a href="/admin" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-lg text-sm font-semibold hover:shadow-lg transition">Dashboard</a>
                    @else
                        <a href="/login" class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-semibold hover:bg-gray-800 transition">Login Admin</a>
                    @endauth
                </div>
                <!-- Mobile Menu Button -->
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t px-4 pb-4">
            <a href="#hero" class="block py-2 text-sm font-medium text-gray-600">Beranda</a>
            <a href="#calendar" class="block py-2 text-sm font-medium text-gray-600">Ketersediaan</a>
            <a href="#booking" class="block py-2 text-sm font-medium text-gray-600">Booking</a>
            <a href="#comments" class="block py-2 text-sm font-medium text-gray-600">Komentar</a>
            @auth
                <a href="/admin" class="block py-2 text-sm font-semibold text-amber-600">Dashboard</a>
            @else
                <a href="/login" class="block py-2 text-sm font-semibold text-gray-900">Login Admin</a>
            @endauth
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <p class="text-sm font-semibold text-white mb-1">SewaVIP Pekanbaru</p>
            <p class="text-xs">&copy; {{ date('Y') }} SewaVIP. All rights reserved.</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
