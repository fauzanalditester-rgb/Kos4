<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Penyewa</h1>
            <p class="text-gray-400 text-sm mt-1">{{ $activeTenants->count() }} penyewa aktif + {{ $completedTenants->count() }} selesai</p>
        </div>
        <button wire:click="openModal" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-semibold rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Penyewa
        </button>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-[#0d9488]/10 border border-[#0d9488]/20 text-[#0d9488] px-4 py-3 rounded-xl text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search -->
    <div class="max-w-md">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" wire:model.live="search" class="block w-full pl-10 pr-4 py-2.5 bg-[#111827] border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-[#0d9488] text-sm" placeholder="Cari nama atau kode kamar...">
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Active Tenants -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-[#0d9488] rounded-full"></span>
                <h2 class="text-sm font-semibold text-white">Penyewa Aktif</h2>
                <span class="bg-gray-800 text-gray-400 text-xs px-2 py-0.5 rounded-full">{{ $activeTenants->count() }}</span>
            </div>

            <div class="space-y-4">
                @forelse($activeTenants as $tenant)
                    <div class="bg-[#111827] border border-gray-800/50 rounded-xl p-5">
                        <div class="flex items-start gap-4">
                            <!-- Avatar -->
                            <div class="w-12 h-12 {{ $tenant->avatar_color }} rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-sm">{{ $tenant->initials }}</span>
                            </div>

                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="text-white font-semibold">{{ $tenant->name }}</h3>
                                        <p class="text-gray-500 text-xs mt-0.5">{{ $tenant->room->code }} • {{ $tenant->property->name }}</p>
                                    </div>
                                    <span class="bg-[#0d9488]/20 text-[#0d9488] text-xs px-2.5 py-1 rounded-lg font-medium">Aktif</span>
                                </div>

                                <div class="mt-3 space-y-1.5">
                                    <div class="flex items-center gap-2 text-xs text-gray-400">
                                        <svg class="w-3.5 h-3.5 text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span>{{ $tenant->phone }}</span>
                                    </div>
                                    @if($tenant->email)
                                        <div class="flex items-center gap-2 text-xs text-gray-400">
                                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $tenant->email }}</span>
                                        </div>
                                    @endif
                                    @if($tenant->id_card_number)
                                        <div class="flex items-center gap-2 text-xs text-gray-400">
                                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3 3 0 01-3-3V6"/>
                                            </svg>
                                            <span>{{ substr($tenant->id_card_number, 0, 4) }}xxxx</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-2 text-xs text-gray-400">
                                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Masuk: {{ $tenant->move_in_date->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-400">
                                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Sudah: {{ $tenant->duration }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 pt-4 border-t border-gray-800/50 flex items-center gap-3">
                            @if($tenant->hasIdCard())
                                <button wire:click="openIdCardModal({{ $tenant->id }})" class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat KTP
                                </button>
                            @else
                                <button wire:click="openIdCardModal({{ $tenant->id }})" class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Upload KTP
                                </button>
                            @endif
                            <button wire:click="editTenant({{ $tenant->id }})" class="p-2 text-gray-400 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </button>
                            <button wire:click="checkoutTenant({{ $tenant->id }})" wire:confirm="Apakah Anda yakin ingin checkout penyewa ini?" class="p-2 text-gray-400 hover:text-[#0d9488] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                            <button wire:click="deleteTenant({{ $tenant->id }})" wire:confirm="Apakah Anda yakin ingin menghapus penyewa ini?" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 bg-[#111827] border border-gray-800/50 rounded-xl">
                        <div class="w-12 h-12 bg-gray-800/50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="text-gray-400 text-sm">Belum ada penyewa aktif</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Completed Tenants -->
        <div class="space-y-4">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-gray-500 rounded-full"></span>
                <h2 class="text-sm font-semibold text-white">Selesai / Checkout</h2>
                <span class="bg-gray-800 text-gray-400 text-xs px-2 py-0.5 rounded-full">{{ $completedTenants->count() }}</span>
            </div>

            <div class="space-y-4">
                @forelse($completedTenants as $tenant)
                    <div class="bg-[#111827] border border-gray-800/50 rounded-xl p-5 opacity-75">
                        <div class="flex items-start gap-4">
                            <!-- Avatar -->
                            <div class="w-10 h-10 bg-gray-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-xs">{{ $tenant->initials }}</span>
                            </div>

                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <h3 class="text-white font-medium text-sm">{{ $tenant->name }}</h3>
                                    <span class="bg-gray-600/20 text-gray-400 text-xs px-2 py-0.5 rounded">Selesai</span>
                                </div>
                                <p class="text-gray-500 text-xs mt-1">{{ $tenant->room->code ?? '-' }} • {{ $tenant->property->name }}</p>

                                <div class="mt-2 space-y-1">
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span>{{ $tenant->phone }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($tenant->hasIdCard())
                            <button wire:click="openIdCardModal({{ $tenant->id }})" class="mt-3 w-full flex items-center justify-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-400 text-xs font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Lihat KTP
                            </button>
                        @else
                            <button wire:click="openIdCardModal({{ $tenant->id }})" class="mt-3 w-full flex items-center justify-center gap-2 px-4 py-2 border border-dashed border-gray-700 hover:border-gray-500 text-gray-500 text-xs font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Upload KTP
                            </button>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-6">
                        <p class="text-gray-500 text-sm">Belum ada riwayat</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-800/50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">{{ $isEditing ? 'Edit Penyewa' : 'Tambah Penyewa' }}</h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form wire:submit="saveTenant" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Properti</label>
                        <select wire:model.live="property_id" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                            <option value="">Pilih Properti</option>
                            @foreach($properties as $property)
                                <option value="{{ $property->id }}">{{ $property->name }}</option>
                            @endforeach
                        </select>
                        @error('property_id') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Kamar</label>
                        <select wire:model="room_id" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                            <option value="">Pilih Kamar</option>
                            @foreach($availableRooms as $room)
                                <option value="{{ $room->id }}">{{ $room->code }} - {{ $room->type }} (Rp {{ number_format($room->price_monthly, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                        @error('room_id') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Nama Lengkap</label>
                        <input type="text" wire:model="name" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Nama penyewa">
                        @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">No. Telepon</label>
                            <input type="text" wire:model="phone" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="0812xxxx">
                            @error('phone') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                            <input type="email" wire:model="email" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="email@example.com">
                            @error('email') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">No. KTP</label>
                            <input type="text" wire:model="id_card_number" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="3171xxxxxxxx">
                            @error('id_card_number') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Deposit</label>
                            <input type="number" wire:model="deposit" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="0">
                            @error('deposit') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Tanggal Masuk</label>
                        <input type="date" wire:model="move_in_date" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                        @error('move_in_date') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Alamat (Opsional)</label>
                        <textarea wire:model="address" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Alamat lengkap..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Kontak Darurat (Opsional)</label>
                        <input type="text" wire:model="emergency_contact" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Nama - No. Telepon">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeModal" class="px-4 py-2.5 text-gray-400 hover:text-white transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white font-medium rounded-xl transition-colors">
                            {{ $isEditing ? 'Simpan Perubahan' : 'Tambah Penyewa' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- ID Card Modal -->
    @if($showIdCardModal && $viewingTenant)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl w-full max-w-md">
                <div class="p-6 border-b border-gray-800/50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">KTP - {{ $viewingTenant->name }}</h3>
                    <button wire:click="closeIdCardModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="p-6 space-y-4">
                    @if($viewingTenant->id_card_photo)
                        <div class="bg-gray-900 rounded-xl overflow-hidden">
                            <img src="{{ asset('storage/' . $viewingTenant->id_card_photo) }}" alt="KTP" class="w-full h-auto">
                        </div>
                        <div class="flex items-center justify-center gap-2 text-sm text-gray-400">
                            <span>No. KTP: {{ $viewingTenant->id_card_number ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Ganti KTP
                                <input type="file" wire:model="idCardFile" class="hidden" accept="image/*">
                            </label>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3 3 0 01-3-3V6"/>
                                </svg>
                            </div>
                            <p class="text-gray-400 text-sm mb-4">Belum ada foto KTP</p>
                            <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Upload KTP
                                <input type="file" wire:model="idCardFile" class="hidden" accept="image/*">
                            </label>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
