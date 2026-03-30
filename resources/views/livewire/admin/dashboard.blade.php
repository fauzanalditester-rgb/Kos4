<div>
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">Dashboard</h1>
        <p class="text-sm font-medium text-gray-500">Selamat datang kembali! Berikut ringkasan kos Anda.</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5 mb-10">
        <!-- Total Kamar -->
        <div class="bg-[#111827] rounded-3xl p-6 border border-gray-800/50 hover:border-[#0f766e]/30 transition-all group">
            <div class="flex items-center justify-between mb-6">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Total Kamar</span>
                <div class="w-8 h-8 rounded-lg bg-[#0f766e]/10 flex items-center justify-center text-[#0f766e]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white">1</div>
        </div>

        <!-- Occupancy Rate -->
        <div class="bg-[#111827] rounded-3xl p-6 border border-gray-800/50 hover:border-[#0f766e]/30 transition-all group">
            <div class="flex items-center justify-between mb-6">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Occupancy</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white">{{ $activeBookings > 0 ? '100' : '0' }}%</div>
        </div>

        <!-- Total Tagihan (Income Month) -->
        <div class="bg-[#111827] rounded-3xl p-6 border border-gray-800/50 hover:border-[#0f766e]/30 transition-all group lg:col-span-2 xl:col-span-1">
            <div class="flex items-center justify-between mb-6">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Total Tagihan</span>
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <div class="text-xl font-extrabold text-white truncate">Rp {{ number_format($monthIncome, 0, ',', '.') }}</div>
        </div>

        <!-- Sudah Bayar -->
        <div class="bg-[#111827] rounded-3xl p-6 border border-gray-800/50 hover:border-[#0f766e]/30 transition-all group lg:col-span-2 xl:col-span-1">
            <div class="flex items-center justify-between mb-6">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Sudah Bayar</span>
                <div class="w-8 h-8 rounded-lg bg-[#0f766e]/10 flex items-center justify-center text-[#0f766e]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
            </div>
            <div class="text-xl font-extrabold text-white truncate">Rp {{ number_format($todayIncome, 0, ',', '.') }}</div>
        </div>

        <!-- Overdue -->
        <div class="bg-[#111827] rounded-3xl p-6 border border-gray-800/50 hover:border-[#0f766e]/30 transition-all group">
            <div class="flex items-center justify-between mb-6">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Overdue</span>
                <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white">0</div>
        </div>

        <!-- Pengeluran Aktif -->
        <div class="bg-[#111827] rounded-3xl p-6 border border-gray-800/50 hover:border-[#0f766e]/30 transition-all group">
            <div class="flex items-center justify-between mb-6">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Expense</span>
                <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center text-yellow-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white">0</div>
        </div>
    </div>

    <!-- Reminder Section -->
    <div class="bg-[#111827] rounded-[2.5rem] p-8 border border-gray-800/50 mb-10 overflow-hidden relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-[#0f766e]/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="flex items-center gap-3 mb-8 relative z-10">
            <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <h3 class="text-lg font-bold text-white tracking-tight">Reminder Pembayaran</h3>
            <span class="px-2.5 py-0.5 bg-amber-500/20 text-amber-500 text-[10px] font-bold rounded-full border border-amber-500/20">{{ count($recentBookings) }}</span>
        </div>

        <div class="space-y-4 relative z-10">
            @forelse($recentBookings as $booking)
            <div class="flex items-center justify-between p-5 bg-gray-900/50 rounded-2xl border border-gray-800/50 hover:border-[#0f766e]/20 transition-all group">
                <div class="flex items-center gap-4">
                    <div class="w-1.5 h-10 bg-[#0f766e] rounded-full"></div>
                    <div>
                        <p class="text-sm font-bold text-white group-hover:text-[#0f766e] transition-colors">{{ $booking->guest_name }} <span class="text-gray-600 mx-2">—</span> <span class="text-gray-400 font-medium text-xs">Kamar VIP 1</span></p>
                        <p class="text-[11px] text-gray-500 font-medium">Sewa: {{ $booking->start_date->format('d M') }} - {{ $booking->end_date->format('d M 2026') }} <span class="text-gray-600 px-1">•</span> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
                <button class="flex items-center gap-2 px-4 py-2 bg-gray-800 text-gray-400 text-[11px] font-bold rounded-xl border border-gray-700/50 hover:bg-[#0f766e]/10 hover:text-[#0f766e] hover:border-[#0f766e]/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Tandai Selesai
                </button>
            </div>
            @empty
            <p class="text-sm text-gray-600 italic">Tidak ada antrean pembayaran.</p>
            @endforelse
        </div>
    </div>

    <!-- Bottom Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cashflow Bar Chart -->
        <div class="lg:col-span-2 bg-[#111827] rounded-[2.5rem] p-8 border border-gray-800/50">
            <h3 class="text-lg font-bold text-white tracking-tight mb-8">Cashflow 6 Bulan Terakhir</h3>
            
            <div class="flex items-end justify-between h-48 gap-4 px-2">
                @php
                    $months = ['Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb'];
                    $incomes = [18, 19, 21, 23, 26, 25]; // in millions
                    $expenses = [3, 2, 4, 5, 2, 3]; // in millions
                @endphp
                @foreach($months as $index => $month)
                <div class="flex-1 flex flex-col items-center gap-3 group relative">
                    <div class="flex items-end gap-1.5 w-full justify-center">
                        <div class="w-3 xl:w-4 bg-[#0f766e] rounded-t-sm transition-all duration-500 group-hover:brightness-125" style="height: {{ ($incomes[$index] / 30) * 100 }}%"></div>
                        <div class="w-3 xl:w-4 bg-red-500/80 rounded-t-sm transition-all duration-500 group-hover:brightness-125" style="height: {{ ($expenses[$index] / 30) * 100 }}%"></div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-600">{{ $month }}</span>
                </div>
                @endforeach
            </div>

            <!-- Legend -->
            <div class="flex items-center justify-center gap-6 mt-10">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-[#0f766e] rounded-sm"></div>
                    <span class="text-xs font-bold text-gray-500">Pemasukan</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-red-500/80 rounded-sm"></div>
                    <span class="text-xs font-bold text-gray-500">Pengeluaran</span>
                </div>
            </div>
        </div>

        <!-- Occupancy Progress Bars -->
        <div class="bg-[#111827] rounded-[2.5rem] p-8 border border-gray-800/50">
            <h3 class="text-lg font-bold text-white tracking-tight mb-8">Occupancy per Properti</h3>
            
            <div class="space-y-8">
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs font-bold text-white">SewaVIP Exclusive</span>
                        <span class="text-[10px] font-bold text-gray-500">{{ $activeBookings }}/1 ({{ $activeBookings > 0 ? '100' : '0' }}%)</span>
                    </div>
                    <div class="h-2 bg-gray-900 rounded-full overflow-hidden">
                        <div class="h-full bg-[#0f766e] transition-all duration-1000 shadow-[0_0_12px_rgba(15,118,110,0.5)]" style="width: {{ $activeBookings > 0 ? '100' : '0' }}%"></div>
                    </div>
                </div>

                <!-- Another Properti Example -->
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs font-bold text-white">Guest House Unit B</span>
                        <span class="text-[10px] font-bold text-gray-500">0/1 (0%)</span>
                    </div>
                    <div class="h-2 bg-gray-900 rounded-full overflow-hidden">
                        <div class="h-full bg-gray-700 transition-all duration-1000" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
