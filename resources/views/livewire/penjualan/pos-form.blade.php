<div class="grid grid-cols-12 gap-6">

    <div class="col-span-12 lg:col-span-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="outlet" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Outlet</label>
                    <select wire:model.live="selectedOutlet" id="outlet" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600">
                        <option value="">-- Pilih Outlet --</option>
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pelanggan</label>
                    <input type="text" wire:model="customer_name" id="customer_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600">
                </div>
            </div>

            @if($selectedOutlet)
            <div class="relative mb-4">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cari Produk</label>
                <input type="text" wire:model.live.debounce.300ms="searchQuery" id="search" placeholder="Ketik nama produk..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600">
                @if(!empty($searchResults))
                    <ul class="absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md mt-1 shadow-lg">
                        @foreach($searchResults as $product)
                            <li wire:click="addProductToCart({{ $product->id }})" class="px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                                {{ $product->barang->nama }} (Stok: {{ $product->stok }})
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            @endif

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kuantitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($cart as $id => $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item['name'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item['price']) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number" wire:model.live.debounce.500ms="cart.{{ $id }}.quantity" wire:change="updateCartQuantity('{{ $id }}', $event.target.value)" class="w-20 rounded-md border-gray-300 shadow-sm dark:bg-gray-900" min="1" max="{{ $item['max_stok'] }}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item['price'] * $item['quantity']) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button wire:click="removeCartItem('{{ $id }}')" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Keranjang kosong.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium mb-4">Ringkasan</h3>
            <div class="flex justify-between items-center py-4 border-t border-b dark:border-gray-700">
                <span class="text-xl font-bold">Total</span>
                <span class="text-xl font-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
            </div>
            <div class="mt-6">
                <button wire:click="saveSale" wire:loading.attr="disabled" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 disabled:bg-green-400">
                    <span wire:loading.remove>Simpan Transaksi</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
</div>