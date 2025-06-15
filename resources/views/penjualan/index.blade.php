<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-semibold">Riwayat Penjualan</h1>
                    <a href="{{ route('penjualan.create') }}" class="create-link text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">
                        <i class="fas fa-plus mr-2"></i>Buat Transaksi Baru
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto relative sm:rounded-lg">
                    <table id="data-table" class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">No. Transaksi</th>
                                <th class="px-6 py-3">Outlet</th>
                                <th class="px-6 py-3">Pelanggan</th>
                                <th class="px-6 py-3 text-right">Total</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            </tbody>
                    </table>
                </div>
                </div>
        </div>
    </div>
</div>