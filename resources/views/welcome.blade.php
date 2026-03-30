@php
    $setting = \App\Models\Setting::first();
@endphp

<x-layouts.public>
    <!-- Hero Section -->
    <section id="hero" class="relative pt-24 pb-32 overflow-hidden flex items-center justify-center min-h-[90vh]">
        <!-- Refined Background -->
        <div class="absolute inset-0 bg-white"></div>
        <div class="absolute top-0 right-0 w-[40rem] h-[40rem] bg-slate-50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[40rem] h-[40rem] bg-yellow-50/50 rounded-full blur-3xl translate-y-1/3 -translate-x-1/3"></div>

        <div class="relative max-w-6xl mx-auto px-6 lg:px-8 w-full">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-[#333333] leading-[1.1] mb-8 tracking-tight">
                    Pengalaman Inap
                    <br><span class="text-[#FFCC00] leading-tight">VIP Eksklusif</span>
                </h1>

                <p class="text-lg sm:text-xl text-[#333333] mb-10 max-w-2xl mx-auto leading-relaxed font-normal">
                    {{ $setting->room_description ?? 'Satu-satunya kamar premium di jantung Pekanbaru yang mendefinisikan ulang makna privasi, kenyamanan, dan kemewahan modern.' }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="#booking" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-10 py-4 bg-[#FFCC00] text-[#333333] font-bold text-sm hover:bg-[#E6B800] transition-colors duration-300 uppercase tracking-wide">
                        Pesan Sekarang
                    </a>
                    <a href="#calendar" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-10 py-4 bg-white text-[#333333] font-bold text-sm border-2 border-[#FFCC00] hover:bg-gray-50 transition-colors duration-300 uppercase tracking-wide">
                        Cek Jadwal
                    </a>
                </div>
            </div>

            <!-- Premium Feature Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-24">
                <div class="bg-white/60 backdrop-blur-xl rounded-3xl p-6 border border-slate-100/50 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center mb-5 text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.858 15.355-5.858 21.213 0"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-900 mb-1">High-Speed WiFi</p>
                    <p class="text-xs text-slate-500">Koneksi stabil tanpa batas</p>
                </div>
                <div class="bg-white/60 backdrop-blur-xl rounded-3xl p-6 border border-slate-100/50 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center mb-5 text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-900 mb-1">Premium AC</p>
                    <p class="text-xs text-slate-500">Udara sejuk & pembersihan rutin</p>
                </div>
                <div class="bg-white/60 backdrop-blur-xl rounded-3xl p-6 border border-slate-100/50 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center mb-5 text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-900 mb-1">Smart TV 43"</p>
                    <p class="text-xs text-slate-500">Netflix & YouTube Ready</p>
                </div>
                <div class="bg-white/60 backdrop-blur-xl rounded-3xl p-6 border border-slate-100/50 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center mb-5 text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-900 mb-1">Bebas Akses</p>
                    <p class="text-xs text-slate-500">Kunci pintar & strategis</p>
                </div>
            </div>

            <!-- Sleek Pricing -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center mt-12 max-w-2xl mx-auto">
                <div class="flex-1 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col justify-between group hover:border-slate-200 transition-colors">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Harian</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold text-slate-900">Rp {{ number_format($setting->price_daily ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex-1 bg-slate-900 rounded-3xl p-8 border border-slate-800 shadow-[0_8px_30px_rgb(0,0,0,0.12)] relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/20 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-amber-500/30 transition-colors"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-xs font-bold text-amber-400 uppercase tracking-widest">Mingguan</p>
                            <span class="px-2 py-0.5 bg-amber-400/10 text-amber-400 text-[10px] font-bold rounded">BEST VALUE</span>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold text-white">Rp {{ number_format($setting->price_weekly ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Calendar Section -->
    <section id="calendar" class="py-24 bg-[#FAFAFA] border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-sm font-bold text-amber-500 tracking-widest uppercase mb-3">Reservasi</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-slate-900">Jadwal Ketersediaan</h3>
            </div>
            <livewire:availability-calendar />
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="py-24 bg-white border-t border-slate-100">
        <div class="max-w-3xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-sm font-bold text-amber-500 tracking-widest uppercase mb-3">Kalkulasi</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-slate-900">Estimasi & Booking</h3>
            </div>
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 p-8">
                <livewire:booking-calculator />
            </div>
        </div>
    </section>

    <!-- Comments Section -->
    <section id="comments" class="py-24 bg-[#FAFAFA] border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-sm font-bold text-amber-500 tracking-widest uppercase mb-3">Interaksi</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-slate-900">Diskusi & Testimoni</h3>
            </div>
            <livewire:comment-board />
        </div>
    </section>
</x-layouts.public>
