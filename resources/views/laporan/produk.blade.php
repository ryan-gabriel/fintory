<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                
                <!-- Tab Menu -->
                <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tab-menu" role="tablist">
                        <li class="mr-2">
                            <a href="{{ route('laporan.stok.mutasi-stok.index') }}"
                               class="inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 menu-link">
                                Mutasi Stok
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="{{ route('laporan.stok.produk.index') }}"
                               class="inline-block p-4 border-b-2 rounded-t-lg'border-blue-600 text-blue-600 menu-link"
                               aria-current="page">
                                Product
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Tab Menu -->

                <h1 class="text-2xl font-semibold">Laporan Mutasi Stok <span id="current_selected_outlet_name">{{ $selectedOutletName }}</span></h1>


                <div class="w-full mt-5 flex flex-col md:flex-row md:justify-between md:items-center gap-4 md:gap-24">
                    <div class="flex items-center gap-2">
                        <p class="text-gray-600 text-sm">Filter Tanggal:</p>
                        <x-date-range-picker />
                    </div>
                </div>

                <div class="overflow-x-auto relative p-5 sm:rounded-lg">
                    <table id="data-table" class="display">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Kategori</th>
                                <th>Outlet</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Kategori</th>
                                <th>Outlet</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
