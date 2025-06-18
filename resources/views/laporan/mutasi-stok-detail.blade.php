    <div>
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('laporan.stok.mutasi-stok.index') }}"
                    class="inline-flex items-center text-sm text-gray-700 hover:text-blue-600 transition-colors duration-200 mb-4 menu-link" data-title="Laporan Stok">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </a>

                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Detail Mutasi Stok</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-800 dark:text-gray-100">
                        <div>
                            <p class="text-sm font-semibold">Produk</p>
                            <p>{{ $mutation->product->barang->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Outlet</p>
                            <p>{{ $mutation->outlet->name ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-semibold">Kuantitas</p>
                            <p class="{{ $mutation->quantity >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $mutation->quantity }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Tipe Mutasi</p>
                            <p class="uppercase">{{ $mutation->type }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('laporan.stok.mutasi-stok.index') }}"
                        class="inline-block px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600 transition menu-link">← Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
