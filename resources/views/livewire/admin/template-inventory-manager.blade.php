<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Template Inventaris</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola daftar item inventaris default untuk kamar</p>
        </div>
        <button wire:click="openModal" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-semibold rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Item
        </button>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-[#0d9488]/10 border border-[#0d9488]/20 text-[#0d9488] px-4 py-3 rounded-xl text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Info Banner -->
    <div class="bg-[#0d9488]/5 border border-[#0d9488]/10 rounded-xl p-4 flex items-start gap-3">
        <div class="w-6 h-6 rounded-full bg-[#0d9488]/20 flex items-center justify-center flex-shrink-0 mt-0.5">
            <svg class="w-4 h-4 text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-gray-300 text-sm">
            Item di sini akan muncul sebagai <span class="text-white font-semibold">checklist saat menambah kamar baru</span>. Anda bisa memilih item mana yang dimasukkan ke inventaris kamar.
        </p>
    </div>

    <!-- Items Table -->
    <div class="bg-[#111827] border border-gray-800/50 rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800/50">
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Nama Item</th>
                    <th class="text-center text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Qty</th>
                    <th class="text-center text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Kondisi</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Harga Beli</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Catatan</th>
                    <th class="text-center text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50">
                @forelse($items as $item)
                    <tr class="hover:bg-gray-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-white font-medium text-sm">{{ $item->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-white text-sm">{{ $item->quantity }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $item->condition_color }}">
                                {{ $item->condition_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-white text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-400 text-sm">{{ $item->notes ?: '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button wire:click="editItem({{ $item->id }})" class="p-2 text-gray-400 hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                                <button wire:click="deleteItem({{ $item->id }})" wire:confirm="Apakah Anda yakin ingin menghapus item ini?" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <h3 class="text-gray-300 font-medium mb-1">Belum ada item</h3>
                            <p class="text-gray-500 text-sm mb-4">Tambahkan item template untuk kamar</p>
                            <button wire:click="openModal" class="inline-flex items-center gap-2 px-4 py-2 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Item
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
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-800/50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">
                        {{ $isEditing ? 'Edit Item' : 'Tambah Item' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form wire:submit="saveItem" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Nama Item</label>
                        <input type="text" wire:model="name" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Contoh: AC">
                        @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Quantity</label>
                            <input type="number" wire:model="quantity" min="1" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                            @error('quantity') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Kondisi</label>
                            <select wire:model="condition" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                                <option value="new">Baru</option>
                                <option value="good">Baik</option>
                                <option value="fair">Cukup</option>
                                <option value="poor">Kurang</option>
                                <option value="broken">Rusak</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Harga Beli</label>
                        <input type="number" wire:model="price" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="2500000">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Catatan (Opsional)</label>
                        <textarea wire:model="notes" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Detail tambahan..."></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeModal" class="px-4 py-2.5 text-gray-400 hover:text-white transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white font-medium rounded-xl transition-colors">
                            {{ $isEditing ? 'Simpan' : 'Tambah' }}
                            </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
