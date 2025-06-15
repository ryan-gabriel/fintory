<div>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                <div class="flex flex-col md:flex-row justify-between items-start mb-6 pb-4 border-b dark:border-gray-700">
                    <div>
                        <h1 class="text-2xl font-bold">Detail Transaksi</h1>
                        <p class="font-mono text-lg text-indigo-500">TRX-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-0 text-left md:text-right">
                        <div>Tanggal: {{ \Carbon\Carbon::parse($sale->sale_date)->format('d F Y') }}</div>
                        <div>Kasir: {{ $sale->creator->email ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="font-semibold mb-1">Pelanggan</h3>
                        <p>{{ $sale->customer_name }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Outlet</h3>
                        <p>{{ $sale->outlet->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $sale->outlet->address ?? '' }}</p>
                    </div>
                </div>

                <h3 class="font-semibold mb-2">Item yang Dibeli</h3>
                <div class="overflow-x-auto relative border rounded-lg">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3">Produk</th>
                                <th scope="col" class="px-6 py-3 text-center">Kuantitas</th>
                                <th scope="col" class="px-6 py-3 text-right">Harga Satuan</th>
                                <th scope="col" class="px-6 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium">{{ $item->product->barang->nama ?? 'Produk Dihapus' }}</td>
                                    <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="font-bold bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-base">Grand Total</td>
                                <td class="px-6 py-3 text-right text-base">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('penjualan.index') }}" class="text-white bg-gray-500 hover:bg-gray-600 font-medium rounded-lg text-sm px-5 py-2.5">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Riwayat
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>