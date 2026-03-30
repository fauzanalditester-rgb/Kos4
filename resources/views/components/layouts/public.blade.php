<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SewaVIP - Sewa Kamar VIP Eksklusif di Pekanbaru">
    <title>{{ $title ?? 'SewaVIP - Kamar VIP Eksklusif Pekanbaru' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body { font-family: 'Poppins', sans-serif; letter-spacing: -0.01em; }
        .glass-nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="bg-[#FAFAFA] text-slate-800 antialiased selection:bg-amber-500 selection:text-white">
    <!-- Navbar -->
    <nav class="glass-nav fixed top-0 inset-x-0 z-50 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center shadow-md shadow-slate-900/10 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">Sewa<span class="text-amber-500 font-medium">VIP.</span></span>
                </a>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#hero" class="text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors duration-200">Beranda</a>
                    <a href="#calendar" class="text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors duration-200">Ketersediaan</a>
                    <a href="#booking" class="text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors duration-200">Booking</a>
                    <a href="#comments" class="text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors duration-200">Diskusi</a>
                </div>
                <!-- Mobile Menu Button -->
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-100 px-6 py-4 space-y-2 shadow-xl absolute w-full">
            <a href="#hero" class="block py-2.5 text-sm font-semibold text-slate-600">Beranda</a>
            <a href="#calendar" class="block py-2.5 text-sm font-semibold text-slate-600">Ketersediaan</a>
            <a href="#booking" class="block py-2.5 text-sm font-semibold text-slate-600">Booking</a>
            <a href="#comments" class="block py-2.5 text-sm font-semibold text-slate-600">Diskusi</a>
        </div>
    </nav>

    <main class="pt-20">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-16 mt-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100">
                 <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2">SewaVIP Exclusive Kos</h3>
            <p class="text-sm text-slate-500 max-w-md mx-auto leading-relaxed mb-8">Memberikan pengalaman menginap premium dengan privasi dan kenyamanan maksimal di jantung kota Pekanbaru.</p>
            <div class="text-xs text-slate-400 font-medium tracking-wide uppercase">&copy; {{ date('Y') }} SewaVIP. All rights reserved.</div>
        </div>
    </footer>

    @livewireScripts
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href').substring(1);
                if (!targetId) return;
                
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    document.getElementById('mobile-menu').classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
