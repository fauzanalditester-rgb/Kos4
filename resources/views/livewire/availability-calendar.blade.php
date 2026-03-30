<div wire:poll.5s class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between px-8 py-6 bg-slate-900 border-b border-slate-800">
            <button wire:click="previousMonth" class="p-2.5 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <h3 class="text-xl font-extrabold tracking-wide text-white uppercase">{{ $this->monthName }}</h3>
            <button wire:click="nextMonth" class="p-2.5 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

        <div class="p-6 sm:p-8">
            <!-- Day Headers -->
            <div class="grid grid-cols-7 gap-2 mb-4">
                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                    <div class="text-center text-xs font-bold text-slate-400 uppercase tracking-widest py-2">{{ $day }}</div>
                @endforeach
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 gap-2">
                @foreach($calendarDays as $cell)
                    @if($cell['date'] === null)
                        <div class="aspect-square"></div>
                    @else
                        <div class="aspect-square flex items-center justify-center rounded-2xl text-sm font-bold transition-all duration-300
                            @if($cell['booked'])
                                bg-red-50 text-red-500 border border-red-100
                            @elseif($cell['isPast'])
                                bg-slate-50 text-slate-300 border border-transparent
                            @else
                                bg-emerald-50 text-emerald-600 border border-emerald-100 hover:bg-emerald-500 hover:text-white hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5 cursor-pointer
                            @endif
                        ">
                            {{ $cell['day'] }}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Legend -->
        <div class="flex items-center justify-center gap-8 px-6 py-5 bg-slate-50 border-t border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                <span class="text-xs font-bold tracking-wide text-slate-600 uppercase">Tersedia</span>
            </div>
            <div class="flex items-center gap-2.5">
                <div class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.5)]"></div>
                <span class="text-xs font-bold tracking-wide text-slate-600 uppercase">Terisi</span>
            </div>
            <div class="flex items-center gap-2.5">
                <div class="w-2.5 h-2.5 rounded-full bg-slate-300"></div>
                <span class="text-xs font-bold tracking-wide text-slate-600 uppercase">Lewat</span>
            </div>
        </div>
    </div>
</div>
