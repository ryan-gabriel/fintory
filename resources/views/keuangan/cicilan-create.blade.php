<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5">
            <h1 class="text-2xl font-semibold mb-5">Tambah Cicilan</h1>
            <form action="/dashboard/keuangan/cicilan" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="hutang" class="block mb-2 text-gray-900 dark:text-white">Pilih Hutang yang
                        Dibayar</label>
                    <select id="hutang" name="hutang_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option value="" selected disabled hidden>--Pilih Hutang--</option>
                        @foreach ($hutangs as $hutang)
                            <option value="{{ $hutang->id }}">{{ $hutang->nama_pemberi_hutang }} - {{ $hutang->deskripsi}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="metode_pembayaran" class="block mb-2 text-gray-900 dark:text-white">Metode
                        Pembayaran</label>
                    <select id="metode_pembayaran" name="metode_pembayaran"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option value="" selected disabled hidden>--Pilih Metode Pembayaran--</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>


                <div>
                    <label for="jumlah_bayar" class="block mb-2 text-gray-900 dark:text-white">Jumlah Bayar
                        Cicilan</label>
                    <input type="number" id="jumlah_bayar" name="jumlah_bayar" min="1" step="1"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                </div>

                <div>
                    <label for="tanggal_bayar">Tanggal Bayar Cicilan</label>
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="tanggal_bayar" name="tanggal_bayar" datepicker datepicker-autohide datepicker datepicker-format="dd-mm-yyyy"
                            datepicker-buttons datepicker-autoselect-today type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select date" required>
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block text-gray-900 dark:text-white">Deskripsi</label>
                    <textarea id="deskripsi" rows="4" name="deskripsi"
                        class="block p-2.5 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Tuliskan deskripsi untuk cicilan ini..." required></textarea>
                </div>

                <div class="flex justify-end">
                    <button class="bg-green-600 text-white px-6 py-3 rounded-md">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>