<x-admin-layout>
    <div class="my-12 px-4 w-full space-y-8">

        {{-- Judul Halaman --}}
        <div class="mb-4 bg-white p-6 rounded-xl">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Ringkasan data penjualan dan produk</p>
        </div>

        {{-- Info Box --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-emerald-500/90 text-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold">Penjualan Hari Ini</h3>
                <p class="text-2xl mt-2 font-bold">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            </div>
            <div class="bg-sky-500/90 text-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold">Transaksi Hari Ini</h3>
                <p class="text-2xl mt-2 font-bold">{{ $totalTransaction }}</p>
            </div>
            <div class="bg-indigo-500/90 text-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold">Produk Aktif</h3>
                <p class="text-2xl mt-2 font-bold">{{ $activeProductTotal }}</p>
            </div>
            <div class="bg-rose-500/90 text-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold">Stok Kritis (&lt;10)</h3>
                <p class="text-2xl mt-2 font-bold">{{ $lowProductTotal }}</p>
            </div>
        </div>

        {{-- Grafik --}}
        <div class="flex flex-col lg:flex-row gap-6 w-full">
            <div class="w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h5 class="text-3xl font-bold text-gray-900 dark:text-white">
                            Rp {{ number_format($totalSalesLast7Days, 0, ',', '.') }}
                        </h5>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                            Penjualan dalam 7 hari terakhir
                        </p>
                    </div>
                </div>
                <div id="area-chart" class="w-full h-full"></div>
            </div>

            <div class="w-full max-w-lg bg-white rounded-lg shadow-sm dark:bg-gray-800 p-6">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">
                    <h5 class="text-xl font-bold text-gray-900 dark:text-white">
                        Produk Terlaris Bulan Ini
                    </h5>
                </div>

                {{-- Info jika tidak ada produk --}}
                <div id="no-product-info" class="hidden text-center text-gray-600 dark:text-gray-300 py-4">
                    Tidak Ada Produk
                </div>

                {{-- Container chart --}}
                <div id="bar-chart" class="w-full h-full"></div>
            </div>

        </div>

    </div>
</x-admin-layout>
