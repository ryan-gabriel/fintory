<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h1 class="text-2xl font-semibold m">Laporan Keuangan <span id="current_selected_outlet_name">{{$selectedOutletName}}<span></h1>
                
                <div class="flex flex-col md:flex-row gap-4 mt-4">
                    <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg px-6 py-4 flex-1">
                        <div class="text-sm font-medium">Total Saldo Saat Ini</div>
                        <div class="text-2xl font-bold mt-1" id="totalSaldo">
                            {{ number_format($totalSaldo, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg px-6 py-4 flex-1">
                        <div class="text-sm font-medium">Total Hutang Saat Ini</div>
                        <div class="text-2xl font-bold mt-1" id="totalHutang">
                            {{ number_format($totalHutang, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                
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
                                <th>Tipe</th>
                                <th>Sumber</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Saldo Setelah</th>
                                <th>Outlet</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Sumber</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Saldo Setelah</th>
                                <th>Outlet</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
