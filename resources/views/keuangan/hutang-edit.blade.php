<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5">

            <a href="{{ route('keuangan.hutang.index') }}"
            class="inline-flex items-center text-sm text-gray-700 hover:text-blue-600 transition-colors duration-200 mb-4 menu-link" data-title="Hutang">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>

            <h1 class="text-2xl font-semibold mb-5">Edit Hutang</h1>
            <form action="/dashboard/keuangan/hutang/{{ $hutang->id }}" method="POST" class="space-y-6" id="form-edit">
                @csrf
                @method('PATCH')
                <div>
                    <label for="outlet" class="block mb-2 text-gray-900 dark:text-white">Pilih Outlet</label>
                    <select id="outlet" name="outlet"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option value="" disabled hidden>--Pilih Outlet--</option>
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}"
                                {{ $hutang->outlet_id == $outlet->id ? 'selected' : '' }}>
                                {{ $outlet->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="nama_pemberi_hutang" class="block mb-2 text-gray-900 dark:text-white">Nama Pemberi
                        Hutang</label>
                    <input type="text" id="nama_pemberi_hutang" name="nama_pemberi_hutang"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('nama_pemberi_hutang', $hutang->nama_pemberi_hutang) }}" required onclick="(e) => console.log(e)">
                </div>

                <div>
                    <label for="jumlah" class="block mb-2 text-gray-900 dark:text-white">Jumlah Hutang</label>
                    <input type="number" id="jumlah" name="jumlah" min="1" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('jumlah', $hutang->jumlah) }}" required>
                </div>

                <div>
                    <label for="tanggal">Tanggal Hutang</label>
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="tanggal" name="tanggal" datepicker datepicker-autohide datepicker-buttons datepicker-format="dd-mm-yyyy"
                            type="text" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select date" value="{{ old('tanggal',  \Carbon\Carbon::parse($hutang->tanggal_hutang)->format('d/m/Y')) }}" required>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-gray-900 dark:text-white">Deskripsi</label>
                    <textarea id="description" rows="4" name="deskripsi"
                        class="block p-2.5 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Tuliskan deskripsi untuk hutang ini..." required>{{ old('deskripsi', $hutang->deskripsi) }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button id="btn-submit" type="submit" class="bg-green-600 text-white px-6 py-3 rounded-md">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
