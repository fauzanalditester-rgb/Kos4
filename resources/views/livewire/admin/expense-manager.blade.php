<div class="space-y-6">
    <!-- Header Section -->
    <div>
        <h1 class="text-2xl font-bold text-white">Pengeluaran & Inventaris</h1>
        <p class="text-gray-400 text-sm mt-1">Kelola biaya operasional dan inventaris kamar kost Anda.</p>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-[#0d9488]/10 border border-[#0d9488]/20 text-[#0d9488] px-4 py-3 rounded-xl text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Tabs -->
    <div class="flex items-center gap-2 bg-gray-800/50 p-1 rounded-xl w-fit">
        <button wire:click="setTab('expense')" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $activeTab === 'expense' ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-white' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            Pengeluaran
        </button>
        <button wire:click="setTab('inventory')" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $activeTab === 'inventory' ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-white' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Inventaris Kamar
        </button>
    </div>

    @if($activeTab === 'expense')
        <!-- Expense Content -->
        <div class="space-y-4">
            <!-- Filters and Add Button -->
            <div class="flex items-center gap-4">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" wire:model.live="search" class="block w-full pl-10 pr-4 py-2.5 bg-[#111827] border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-[#0d9488] text-sm" placeholder="Cari pengeluaran...">
                    </div>
                </div>
                <select wire:model.live="filterCategory" class="bg-[#111827] border border-gray-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                <button wire:click="openModal('expense')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-semibold rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pengeluaran
                </button>
            </div>

            <!-- Total Card -->
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Pengeluaran</p>
                        <p class="text-3xl font-bold text-[#0d9488] mt-1">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#0d9488]/10 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Expenses Table -->
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-800/50">
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Tanggal</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Judul</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Kategori</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Properti</th>
                            <th class="text-right text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Jumlah</th>
                            <th class="text-right text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        @forelse($expenses as $expense)
                            <tr class="hover:bg-gray-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-gray-300 text-sm">{{ $expense->date->format('d M Y') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <span class="text-white font-medium text-sm block">{{ $expense->title }}</span>
                                        @if($expense->description)
                                            <span class="text-gray-500 text-xs">{{ $expense->description }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border {{ $expense->category_color }}">
                                        {{ $expense->category_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-300 text-sm">{{ $expense->property?->name ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-white font-semibold text-sm">Rp {{ number_format($expense->amount, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="editExpense({{ $expense->id }})" class="p-2 text-gray-400 hover:text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <button wire:click="deleteExpense({{ $expense->id }})" wire:confirm="Apakah Anda yakin ingin menghapus pengeluaran ini?" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-gray-300 font-medium mb-1">Belum ada pengeluaran</h3>
                                    <p class="text-gray-500 text-sm mb-4">Tambahkan pengeluaran pertama Anda</p>
                                    <button wire:click="openModal('expense')" class="inline-flex items-center gap-2 px-4 py-2 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Tambah Pengeluaran
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Inventory Content -->
        <div class="space-y-4">
            <!-- Filters and Add Button -->
            <div class="flex items-center justify-between">
                <div class="max-w-md flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" wire:model.live="search" class="block w-full pl-10 pr-4 py-2.5 bg-[#111827] border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-[#0d9488] text-sm" placeholder="Cari inventaris...">
                    </div>
                </div>
                <button wire:click="openModal('inventory')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-semibold rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Inventaris
                </button>
            </div>

            <!-- Inventory Table -->
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-800/50">
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Nama Barang</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Kategori</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Lokasi</th>
                            <th class="text-center text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Qty</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Kondisi</th>
                            <th class="text-right text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        @forelse($inventories as $inventory)
                            <tr class="hover:bg-gray-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-white font-medium text-sm">{{ $inventory->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-300 text-sm">{{ $inventory->category }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-300 text-sm">{{ $inventory->room?->code ?? $inventory->property?->name ?? 'Umum' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-white text-sm">{{ $inventory->quantity }} {{ $inventory->unit }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $inventory->condition_color }}">
                                        {{ $inventory->condition_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="editInventory({{ $inventory->id }})" class="p-2 text-gray-400 hover:text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <button wire:click="deleteInventory({{ $inventory->id }})" wire:confirm="Apakah Anda yakin ingin menghapus inventaris ini?" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
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
                                    <h3 class="text-gray-300 font-medium mb-1">Belum ada inventaris</h3>
                                    <p class="text-gray-500 text-sm mb-4">Tambahkan inventaris pertama Anda</p>
                                    <button wire:click="openModal('inventory')" class="inline-flex items-center gap-2 px-4 py-2 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Tambah Inventaris
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-800/50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">
                        @if($modalType === 'expense')
                            {{ $isEditing ? 'Edit Pengeluaran' : 'Tambah Pengeluaran' }}
                        @else
                            {{ $isEditing ? 'Edit Inventaris' : 'Tambah Inventaris' }}
                        @endif
                    </h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                @if($modalType === 'expense')
                    <form wire:submit="saveExpense" class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Properti (Opsional)</label>
                            <select wire:model="property_id" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                                <option value="">Pilih Properti</option>
                                @foreach($properties as $prop)
                                    <option value="{{ $prop->id }}">{{ $prop->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Tanggal</label>
                            <input type="date" wire:model="date" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                            @error('date') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Judul</label>
                            <input type="text" wire:model="title" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Contoh: Gaji Pak Budi">
                            @error('title') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Keterangan (Opsional)</label>
                            <textarea wire:model="description" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Detail pengeluaran..."></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Kategori</label>
                                <select wire:model="category" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('category') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Jumlah</label>
                                <input type="number" wire:model="amount" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="1000000">
                                @error('amount') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
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
                @else
                    <form wire:submit="saveInventory" class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Properti</label>
                                <select wire:model="inventory_property_id" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                                    <option value="">Pilih Properti</option>
                                    @foreach($properties as $prop)
                                        <option value="{{ $prop->id }}">{{ $prop->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Kamar (Opsional)</label>
                                <select wire:model="room_id" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                                    <option value="">Pilih Kamar</option>
                                    @foreach($rooms as $rm)
                                        <option value="{{ $rm->id }}">{{ $rm->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Nama Barang</label>
                            <input type="text" wire:model="item_name" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Contoh: Meja Belajar">
                            @error('item_name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Kategori</label>
                                <input type="text" wire:model="inventory_category" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Contoh: Furniture">
                                @error('inventory_category') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
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

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Jumlah</label>
                                <input type="number" wire:model="quantity" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" min="1">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Satuan</label>
                                <input type="text" wire:model="unit" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="pcs, set, dll">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Harga Beli</label>
                            <input type="number" wire:model="price" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="500000">
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
                @endif
            </div>
        </div>
    @endif
</div>
