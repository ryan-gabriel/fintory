<div>
    <div class="mb-4">
        <label for="jumlah" class="block mb-2 text-gray-900 dark:text-white">Jumlah Uang (Rp.)</label>
        <input type="text" id="jumlah" wire:model.live.debounce.300ms="jumlah"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
            placeholder="Masukkan jumlah angka" required>
    </div>

    <div>
        <label for="terbilang" class="block mb-2 text-gray-900 dark:text-white">Terbilang</label>
        <input type="text" id="terbilang" value="{{ $terbilang }}" readonly
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            disabled>
    </div>
</div>