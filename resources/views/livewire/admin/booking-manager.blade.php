<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Kelola Booking</h1>
        <button wire:click="$toggle('showForm')" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-lg transition">
            {{ $showForm ? 'Tutup Form' : '+ Tambah Booking' }}
        </button>
    </div>

    @if($showForm)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">{{ $editingId ? 'Edit Booking' : 'Booking Baru' }}</h3>
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Tamu</label>
                        <input type="text" wire:model="guest_name" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        @error('guest_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" wire:model="phone" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        @error('phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Check-in</label>
                        <input type="date" wire:model.live="start_date" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        @error('start_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Check-out</label>
                        <input type="date" wire:model.live="end_date" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        @error('end_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                        <select wire:model="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Total Harga</label>
                        <div class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-amber-600">
                            Rp {{ number_format($total_price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-lg transition">
                        {{ $editingId ? 'Update' : 'Simpan' }}
                    </button>
                    <button type="button" wire:click="resetForm" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Bookings Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold text-gray-600">Tamu</th>
                        <th class="text-left px-5 py-3 font-semibold text-gray-600">Telepon</th>
                        <th class="text-left px-5 py-3 font-semibold text-gray-600">Check-in</th>
                        <th class="text-left px-5 py-3 font-semibold text-gray-600">Check-out</th>
                        <th class="text-left px-5 py-3 font-semibold text-gray-600">Total</th>
                        <th class="text-left px-5 py-3 font-semibold text-gray-600">Status</th>
                        <th class="text-right px-5 py-3 font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 font-medium text-gray-900">{{ $booking->guest_name }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $booking->phone }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $booking->start_date->format('d/m/Y') }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $booking->end_date->format('d/m/Y') }}</td>
                            <td class="px-5 py-3 font-semibold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : ($booking->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <button wire:click="edit({{ $booking->id }})" class="text-amber-600 hover:text-amber-700 font-medium mr-2">Edit</button>
                                <button wire:click="delete({{ $booking->id }})" wire:confirm="Yakin hapus booking ini?" class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-8 text-center text-gray-400">Belum ada booking</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
