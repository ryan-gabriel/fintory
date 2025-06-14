<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h1 class="text-2xl font-semibold m">Manajemen Barang</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar master semua barang yang tersedia di perusahaan Anda.</p>
                
                <div class="w-full mt-5 flex justify-end items-center">
                    <a href="{{ route('produk-stok.barang.create') }}"
                        class="create-link text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-200 whitespace-nowrap" 
                        data-title="Tambah Barang Baru">
                        <i class="fas fa-plus mr-2"></i>Tambah Barang
                    </a>
                </div>


                <div class="overflow-x-auto relative mt-4 sm:rounded-lg">
                    <table id="data-table" class="display w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>