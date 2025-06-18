<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
             <a href="{{ route('produk-stok.barang.index') }}"
                class="inline-flex items-center text-sm text-gray-700 hover:text-blue-600 transition-colors duration-200 mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-semibold mb-5 text-gray-800 dark:text-white">Tambah Barang Baru</h1>

            <form action="{{ route('produk-stok.barang.store') }}" method="POST" class="ajax-form space-y-6">
                @csrf
                <div>
                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Barang
                        <span class="text-red-500">*</span></label>
                    <input type="text" id="nama" name="nama"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        required>
                </div>

                <div>
                    <label for="deskripsi"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                        (Opsional)</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></textarea>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-3 transition-colors duration-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>