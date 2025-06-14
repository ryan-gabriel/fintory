<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex flex-col md:flex-row justify-between md:items-center mb-4">
                    <div>
                        <h1 class="text-2xl font-semibold">Manajemen Produk</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar produk yang dijual di setiap outlet.</p>
                    </div>
                    <a href="{{ route('produk-stok.produk.create') }}"
                        class="create-link mt-4 md:mt-0 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5" 
                        data-title="Tambah Produk Baru">
                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                    </a>
                </div>

                <div class="overflow-x-auto relative mt-4 sm:rounded-lg">
                    <table id="data-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama Barang</th>
                                <th scope="col" class="px-6 py-3">Kategori</th>
                                <th scope="col" class="px-6 py-3">Outlet</th>
                                <th scope="col" class="px-6 py-3">Harga Jual</th>
                                <th scope="col" class="px-6 py-3">Stok</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>