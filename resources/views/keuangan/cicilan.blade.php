<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h1 class="text-2xl font-semibold m">Daftar Hutang & Cicilan</h1>
                <div class="w-full mt-5 flex flex-col md:flex-row md:justify-between md:items-center gap-4 md:gap-24">
                    <div class="flex items-center gap-2">
                        <p class="text-gray-600 text-sm">Filter Tanggal Hutang:</p>
                        <x-date-range-picker />
                    </div>

                    <a href="/dashboard/keuangan/hutang/create"
                        class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 create-link" data-title="Tambah Hutang Baru">
                        Bayar Hutang +
                    </a>
                </div>

                <div class="overflow-x-auto relative p-5 sm:rounded-lg">
                    <table id="data-table" class="display w-full">
                        <thead>
                            <tr>
                                <th>Tanggal Hutang</th>
                                <th>Pemberi Hutang</th>
                                <th>Total Hutang</th>
                                <th>Sisa Hutang</th>
                                <th>Metode Bayar Terakhir</th>
                                <th>Tgl Bayar Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tanggal Hutang</th>
                                <th>Pemberi Hutang</th>
                                <th>Total Hutang</th>
                                <th>Sisa Hutang</th>
                                <th>Metode Bayar Terakhir</th>
                                <th>Tgl Bayar Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>