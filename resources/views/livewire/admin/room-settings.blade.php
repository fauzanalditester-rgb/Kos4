<div>
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Pengaturan Kamar</h1>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form wire:submit="save" class="space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Harga Harian (Rp)</label>
                    <input type="number" wire:model="price_daily" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Harga Mingguan (Rp)</label>
                    <input type="number" wire:model="price_weekly" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp</label>
                    <input type="text" wire:model="whatsapp_number" placeholder="6281234567890" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <p class="text-xs text-gray-400 mt-1">Format: 62xxx (tanpa + atau 0)</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Kamar</label>
                    <select wire:model="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <option value="available">Tersedia</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Kamar</label>
                <textarea wire:model="room_description" rows="4" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 resize-none"></textarea>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-lg transition">
                Simpan Pengaturan
            </button>
        </form>
    </div>
</div>
