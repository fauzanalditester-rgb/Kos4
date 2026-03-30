<div class="h-[calc(100vh-80px)] flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-[#0d9488]/20 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-[#0d9488]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white">WhatsApp Manager</h1>
                <p class="text-gray-400 text-sm">Kelola komunikasi dengan penghuni kost</p>
            </div>
        </div>
        <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-800/50 rounded-full text-sm text-gray-400">
            <span class="w-2 h-2 bg-gray-500 rounded-full"></span>
            Belum Dikonfigurasi
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex items-center gap-1 mb-4 bg-[#111827] p-1 rounded-xl w-fit">
        <button wire:click="setTab('pesan')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'pesan' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Pesan
            </span>
        </button>
        <button wire:click="setTab('penghuni')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'penghuni' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Penghuni
            </span>
        </button>
        <button wire:click="setTab('templat')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'templat' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Templat
            </span>
        </button>
        <button wire:click="setTab('broadcast')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'broadcast' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                Broadcast
            </span>
        </button>
        <button wire:click="setTab('otomatis')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'otomatis' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Otomatis
            </span>
        </button>
        <button wire:click="setTab('pengaturan')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'pengaturan' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Pengaturan
            </span>
        </button>
    </div>

    <!-- Content Area -->
    <div class="flex-1 bg-[#111827] border border-gray-800/50 rounded-2xl overflow-hidden flex">
        <!-- Left Sidebar - Tenant List -->
        <div class="w-80 border-r border-gray-800/50 flex flex-col">
            <!-- Search -->
            <div class="p-4 border-b border-gray-800/50">
                <div class="relative">
                    <svg class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" wire:model.live="search" placeholder="Cari penghuni..." class="w-full bg-[#0f172a] border border-gray-700 rounded-xl pl-10 pr-4 py-2.5 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                </div>
            </div>

            <!-- Tenant List -->
            <div class="flex-1 overflow-y-auto">
                @forelse($tenants as $tenant)
                    <div wire:click="selectTenant({{ $tenant->id }})" class="flex items-center gap-3 p-4 hover:bg-gray-800/50 cursor-pointer transition-colors border-b border-gray-800/30 {{ $selectedTenant == $tenant->id ? 'bg-gray-800/50' : '' }}">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white {{ $tenant->avatar_color }}" style="background-color: {{ $tenant->avatar_color ?? '#0d9488' }}40;">
                                {{ $tenant->initials }}
                            </div>
                            @if($loop->index < 2)
                                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-[#111827]"></span>
                            @else
                                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-gray-500 rounded-full border-2 border-[#111827]"></span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <h4 class="text-white font-medium text-sm truncate">{{ $tenant->name }}</h4>
                                @if(in_array($tenant->id, [3, 5]))
                                    <span class="px-2 py-0.5 bg-red-500/20 text-red-400 text-xs rounded-full">Menunggak</span>
                                @endif
                            </div>
                            <p class="text-gray-400 text-xs">{{ $tenant->room->property->name ?? '' }} {{ $tenant->room->room_number ?? '' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-500 text-xs">
                                @if($loop->index == 0) Baru saja
                                @elseif($loop->index == 1) 10 menit lalu
                                @elseif($loop->index == 2) 2 jam lalu
                                @elseif($loop->index == 3) 1 jam lalu
                                @elseif($loop->index == 4) 5 jam lalu
                                @else {{ $tenant->updated_at->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <p class="text-gray-500 text-sm">Tidak ada penghuni ditemukan</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Content -->
        <div class="flex-1 flex flex-col items-center justify-center">
            @if($selectedTenant && $selectedTenantData)
                <!-- Chat Interface -->
                <div class="w-full h-full flex flex-col">
                    <!-- Chat Header -->
                    <div class="flex items-center gap-3 p-4 border-b border-gray-800/50">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background-color: {{ $selectedTenantData->avatar_color ?? '#0d9488' }}40;">
                            {{ $selectedTenantData->initials }}
                        </div>
                        <div>
                            <h4 class="text-white font-medium">{{ $selectedTenantData->name }}</h4>
                            <p class="text-gray-400 text-xs">{{ $selectedTenantData->room->property->name ?? '' }} {{ $selectedTenantData->room->room_number ?? '' }}</p>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-4">
                        @forelse($messages as $msg)
                            <div class="flex {{ $msg->direction == 'out' ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[70%] px-4 py-2 rounded-2xl {{ $msg->direction == 'out' ? 'bg-[#0d9488] text-white rounded-br-none' : 'bg-gray-800 text-white rounded-bl-none' }}">
                                    <p class="text-sm">{{ $msg->message }}</p>
                                    <p class="text-xs mt-1 {{ $msg->direction == 'out' ? 'text-[#0d9488]/70' : 'text-gray-500' }}">{{ $msg->sent_at?->format('H:i') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="flex items-center justify-center h-full">
                                <p class="text-gray-500 text-sm">Belum ada pesan. Mulai chat sekarang!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Message Input -->
                    <div class="p-4 border-t border-gray-800/50">
                        <form wire:submit="sendMessage" class="flex items-center gap-2">
                            <input type="text" wire:model="message" placeholder="Ketik pesan..." class="flex-1 bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                            <button type="submit" class="p-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-4 text-[#0d9488]/30">
                        <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm">Pilih penghuni untuk mulai chat</p>
                </div>
            @endif
        </div>
    </div>
</div>
