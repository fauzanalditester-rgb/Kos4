<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Properti</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola semua properti kost Anda.</p>
        </div>
        <button wire:click="openModal" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-semibold rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Properti
        </button>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-[#0d9488]/10 border border-[#0d9488]/20 text-[#0d9488] px-4 py-3 rounded-xl text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($properties as $property)
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl p-6 hover:border-[#0d9488]/30 transition-all">
                <!-- Header with Icon and Edit -->
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-[#0d9488]/10 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $property->occupancy_rate >= 80 ? 'bg-red-500/10 text-red-400' : ($property->occupancy_rate >= 50 ? 'bg-yellow-500/10 text-yellow-400' : 'bg-[#0d9488]/10 text-[#0d9488]') }}">
                            {{ $property->occupancy_rate }}% terisi
                        </span>
                        <button wire:click="editProperty({{ $property->id }})" class="p-2 text-gray-500 hover:text-[#0d9488] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Property Info -->
                <h3 class="text-lg font-semibold text-white mb-2">{{ $property->name }}</h3>
                <div class="flex items-start gap-2 text-gray-400 text-sm mb-4">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="line-clamp-2">{{ $property->address }}</span>
                </div>

                <!-- Room Stats -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400">Kamar:</span>
                        <span class="text-white font-semibold">{{ $property->occupied_rooms }}/{{ $property->total_rooms }}</span>
                    </div>
                    <div class="w-full bg-gray-800 rounded-full h-2">
                        <div class="bg-gradient-to-r from-[#0d9488] to-[#14b8a6] h-2 rounded-full transition-all" style="width: {{ $property->occupancy_rate }}%"></div>
                    </div>
                </div>

                <!-- Contact Info -->
                @if($property->contact_phone || $property->contact_email)
                    <div class="mt-4 pt-4 border-t border-gray-800/50 space-y-1">
                        @if($property->contact_phone)
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $property->contact_phone }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 bg-gray-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-300 mb-2">Belum ada properti</h3>
                <p class="text-gray-500 text-sm mb-4">Tambahkan properti pertama Anda untuk memulai.</p>
                <button wire:click="openModal" class="inline-flex items-center gap-2 px-4 py-2 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Properti
                </button>
            </div>
        @endforelse
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-800/50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">{{ $isEditing ? 'Edit Properti' : 'Tambah Properti' }}</h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form wire:submit="saveProperty" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Nama Properti</label>
                        <input type="text" wire:model="name" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Contoh: Kost Harmoni Residence">
                        @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Alamat</label>
                        <textarea wire:model="address" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Alamat lengkap properti..."></textarea>
                        @error('address') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Total Kamar</label>
                            <input type="number" wire:model="total_rooms" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" min="0">
                            @error('total_rooms') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Kamar Terisi</label>
                            <input type="number" wire:model="occupied_rooms" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" min="0">
                            @error('occupied_rooms') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Deskripsi (Opsional)</label>
                        <textarea wire:model="description" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Deskripsi singkat properti..."></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">No. Telepon (Opsional)</label>
                            <input type="text" wire:model="contact_phone" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="0812xxxx">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Email (Opsional)</label>
                            <input type="email" wire:model="contact_email" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="email@example.com">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeModal" class="px-4 py-2.5 text-gray-400 hover:text-white transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white font-medium rounded-xl transition-colors">
                            {{ $isEditing ? 'Simpan Perubahan' : 'Tambah Properti' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
