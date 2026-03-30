<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Kamar</h1>
            <p class="text-gray-400 text-sm mt-1">{{ $rooms->count() }} kamar terdaftar</p>
        </div>
        <button wire:click="openModal" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-semibold rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kamar
        </button>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-[#0d9488]/10 border border-[#0d9488]/20 text-[#0d9488] px-4 py-3 rounded-xl text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="flex items-center gap-4">
        <div class="flex-1 max-w-md">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" wire:model.live="search" class="block w-full pl-10 pr-4 py-2.5 bg-[#111827] border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-[#0d9488] text-sm" placeholder="Cari kode kamar atau properti...">
            </div>
        </div>
        <select wire:model.live="filterStatus" class="bg-[#111827] border border-gray-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-[#0d9488]">
            <option value="">Semua</option>
            <option value="available">Kosong</option>
            <option value="occupied">Terisi</option>
            <option value="maintenance">Perbaikan</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-[#111827] border border-gray-800/50 rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800/50">
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Kode</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Properti</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Tipe</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Harga/Bulan</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Status</th>
                    <th class="text-right text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50">
                @forelse($rooms as $room)
                    <tr class="hover:bg-gray-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-white font-semibold">{{ $room->code }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-300 text-sm">{{ $room->property->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-300 text-sm">{{ $room->type }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-white text-sm">Rp {{ number_format($room->price_monthly, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border {{ $room->status_color }}">
                                {{ $room->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="editRoom({{ $room->id }})" class="p-2 text-gray-400 hover:text-[#0d9488] transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                                <button wire:click="deleteRoom({{ $room->id }})" wire:confirm="Apakah Anda yakin ingin menghapus kamar ini?" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="w-12 h-12 bg-gray-800/50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <h3 class="text-gray-300 font-medium mb-1">Belum ada kamar</h3>
                            <p class="text-gray-500 text-sm mb-4">Tambahkan kamar pertama Anda</p>
                            <button wire:click="openModal" class="inline-flex items-center gap-2 px-4 py-2 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Kamar
                            </button>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-800/50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">{{ $isEditing ? 'Edit Kamar' : 'Tambah Kamar' }}</h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form wire:submit="saveRoom" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Properti</label>
                        <select wire:model="property_id" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                            <option value="">Pilih Properti</option>
                            @foreach($properties as $property)
                                <option value="{{ $property->id }}">{{ $property->name }}</option>
                            @endforeach
                        </select>
                        @error('property_id') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Kode Kamar</label>
                            <input type="text" wire:model="code" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Contoh: A-101">
                            @error('code') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Lantai</label>
                            <input type="number" wire:model="floor" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" min="1">
                            @error('floor') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Tipe</label>
                            <select wire:model="type" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                                <option value="Standard">Standard</option>
                                <option value="Deluxe">Deluxe</option>
                                <option value="Suite">Suite</option>
                            </select>
                            @error('type') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Harga/Bulan</label>
                            <input type="number" wire:model="price_monthly" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="1500000">
                            @error('price_monthly') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Status</label>
                        <select wire:model="status" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                            <option value="available">Kosong</option>
                            <option value="occupied">Terisi</option>
                            <option value="maintenance">Perbaikan</option>
                        </select>
                        @error('status') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Fasilitas (Opsional)</label>
                        <textarea wire:model="facilities" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="AC, TV, WiFi, Kamar Mandi Dalam..."></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeModal" class="px-4 py-2.5 text-gray-400 hover:text-white transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white font-medium rounded-xl transition-colors">
                            {{ $isEditing ? 'Simpan Perubahan' : 'Tambah Kamar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
