<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div>
                    <h1 class="text-2xl font-semibold">Riwayat Mutasi Stok</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Catatan semua perubahan stok yang terjadi
                        di semua outlet.</p>
                </div>
                <div class="flex items-center gap-2">
                    <p class="text-gray-600 text-sm">Filter Tanggal:</p>
                    <x-date-range-picker />
                </div>

                <div class="overflow-x-auto relative mt-4 sm:rounded-lg">
                    <table id="data-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Tanggal</th>
                                <th scope="col" class="px-6 py-3">Produk</th>
                                <th scope="col" class="px-6 py-3">Outlet</th>
                                <th scope="col" class="px-6 py-3">Tipe</th>
                                <th scope="col" class="px-6 py-3">Kuantitas</th>
                                <th scope="col" class="px-6 py-3">Referensi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>