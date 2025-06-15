<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-semibold">Laporan Penjualan</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Analisis riwayat penjualan Anda dalam rentang waktu tertentu.</p>
                
                <div class="w-full mt-5 flex items-center gap-4">
                    <p class="text-gray-600 dark:text-gray-300 text-sm font-medium">Filter Tanggal:</p>
                    {{-- Menggunakan komponen date-range-picker yang sudah ada --}}
                    <x-date-range-picker />
                </div>

                <div class="overflow-x-auto relative mt-4 sm:rounded-lg">
                    <table id="data-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Tanggal</th>
                                <th scope="col" class="px-6 py-3">No. Transaksi</th>
                                <th scope="col" class="px-6 py-3">Outlet</th>
                                <th scope="col" class="px-6 py-3">Pelanggan</th>
                                <th scope="col" class="px-6 py-3 text-right">Total</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>