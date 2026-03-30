<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin - SewaVIP' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body { font-family: 'Poppins', sans-serif; letter-spacing: -0.01em; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #4b5563; }
    </style>
</head>
<body class="h-full bg-[#0a0e14] text-gray-400 antialiased selection:bg-[#0f766e] selection:text-white overflow-hidden">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-72 bg-[#111827] flex-shrink-0 flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 border-r border-gray-800/50">
            <!-- Logo Section -->
            <div class="p-8 flex items-center justify-between">
                <a href="/admin" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-[#0f766e]" fill="currentColor" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-10a10 10 0 100 20 10 10 0 000-20z"/></svg>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold tracking-tight text-white block">Sewa<span class="text-[#0f766e]">VIP.</span></span>
                        <span class="text-[10px] text-gray-500 font-bold tracking-widest uppercase">Admin Panel</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto px-4 space-y-1 mt-4 scrollbar-hide">
                <div class="text-[10px] font-bold text-gray-600 uppercase tracking-widest px-4 mb-2">Menu Utama</div>
                
                <a href="/admin" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('admin') && !request()->is('admin/*') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </a>

                <a href="/admin/properties" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('admin/properties') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Properti</span>
                </a>

                <a href="/admin/kamar" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('admin/kamar') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Kamar</span>
                </a>

                <a href="/admin/penyewa" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('admin/penyewa') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Penyewa</span>
                </a>

                <a href="/admin/tagihan" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('admin/tagihan') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Tagihan</span>
                </a>

                <a href="/admin/pembayaran" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('admin/pembayaran') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Pembayaran</span>
                </a>

                <a href="/admin/pengeluaran" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('admin/pengeluaran') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0zM3 12a9 9 0 0118 0"/></svg>
                    <span>Pengeluaran</span>
                </a>

                <a href="/admin/inventaris" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('admin/inventaris') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span>Inventaris</span>
                </a>

                <a href="/admin/laporan" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('admin/laporan') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Laporan</span>
                </a>

                <a href="/admin/whatsapp" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('admin/whatsapp') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <span>WhatsApp</span>
                </a>
                
                <div class="pt-8">
                    <div class="text-[10px] font-bold text-gray-600 uppercase tracking-widest px-4 mb-2">Lainnya</div>
                    <a href="/" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold text-gray-400 hover:bg-gray-800/50 hover:text-white transition-all">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>Lihat Situs</span>
                    </a>
                </div>
            </nav>

            <!-- Bottom Section (User & Exit) -->
            <div class="p-6 border-t border-gray-800/50 space-y-3">
                <div class="flex items-center gap-3 px-4 py-3 bg-gray-800/30 rounded-2xl border border-gray-800/50">
                    <div class="w-10 h-10 rounded-xl bg-[#0f766e]/20 flex items-center justify-center text-[#0f766e] font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email ?? 'admin@sewavip.com' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="flex items-center gap-3.5 w-full px-4 py-3 rounded-2xl text-sm font-bold text-red-500/80 hover:bg-red-500/10 hover:text-red-500 transition-all">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Keluar Panel</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-72 flex flex-col h-full bg-[#0a0e14] relative">
            <!-- Header/Top Bar -->
            <header class="h-20 bg-[#0a0e14]/50 backdrop-blur-xl border-b border-gray-800/30 px-8 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4 flex-1">
                    <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="md:hidden p-2.5 bg-gray-800 text-white rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <!-- Search Bar from Image -->
                    <div class="relative w-full max-w-md hidden sm:block">
                        <div class="absolute inset-y-0 left-0 pl-1 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-4 py-2 bg-gray-900 shadow-sm border-0 text-white placeholder-gray-600 rounded-xl focus:ring-1 focus:ring-[#0f766e] sm:text-xs" placeholder="Cari penyewa, booking, atau keuangan...">
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-4 text-gray-500">
                        <button class="p-2.5 bg-gray-900 border border-gray-800/50 rounded-xl text-gray-400 hover:text-white transition-colors relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-[#111827]"></span>
                        </button>
                    </div>
                    <div class="w-10 h-10 bg-[#0f766e] text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-lg shadow-[#0f766e]/20 border border-[#0f766e]/50">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-8 scrollbar-hide">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- OVERLAY for mobile sidebar -->
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-30 md:hidden" onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); this.classList.add('hidden')"></div>

    @livewireScripts
</body>
</html>
