<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold mb-5">Edit Kategori: {{ $kategori->nama }}</h1>
            <form action="{{ route('produk-stok.kategori.update', $kategori->id) }}" method="POST" class="ajax-form space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="nama" class="block mb-2 text-sm font-medium">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div>
                    <label for="deskripsi" class="block mb-2 text-sm font-medium">Deskripsi (Opsional)</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-6 py-3">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>