<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold mb-5">Edit Produk: {{ $produk->barang->nama }}</h1>
            <form action="{{ route('produk-stok.produk.update', $produk->id) }}" method="POST" class="ajax-form space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="barang_id" class="block mb-2 text-sm font-medium">Barang</label>
                    <select id="barang_id" name="barang_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        @foreach ($barangs as $barang)
                            <option value="{{ $barang->kode_barang }}" @selected($produk->barang_id == $barang->kode_barang)>{{ $barang->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="kategori_id" class="block mb-2 text-sm font-medium">Kategori</label>
                    <select id="kategori_id" name="kategori_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" @selected($produk->kategori_id == $kategori->id)>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="outlet_id" class="block mb-2 text-sm font-medium">Outlet</label>
                    <select id="outlet_id" name="outlet_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}" @selected($produk->outlet_id == $outlet->id)>{{ $outlet->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="harga_jual" class="block mb-2 text-sm font-medium">Harga Jual (Rp.)</label>
                    <input type="number" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div>
                    <label for="stok" class="block mb-2 text-sm font-medium">Stok</label>
                    <input type="number" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-6 py-3">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>