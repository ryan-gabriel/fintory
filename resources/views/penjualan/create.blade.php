<div>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-semibold mb-5">Buat Transaksi Baru</h1>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('penjualan.store') }}" method="POST" id="sale-form">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="outlet_id" class="block text-sm font-medium">Outlet <span
                                    class="text-red-500">*</span></label>
                            <select id="outlet_id" name="outlet_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Pilih Outlet --</option>
                                @foreach($outlets as $outlet)
                                    <option value="{{ $outlet->id }}" {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>
                                        {{ $outlet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="customer_name" class="block text-sm font-medium">Nama Pelanggan</label>
                            <input type="text" id="customer_name" name="customer_name"
                                value="{{ old('customer_name', 'Customer') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h3 class="text-lg font-medium mb-2">Keranjang Belanja</h3>
                        <div id="cart-container" class="space-y-4">
                        </div>
                        <button type="button" id="add-product-btn"
                            class="mt-4 text-sm text-blue-600 hover:underline font-semibold" disabled>+ Tambah
                            Produk</button>
                    </div>

                    <div class="flex justify-end mt-6 text-xl font-bold border-t pt-4">
                        <span class="mr-4">Grand Total:</span>
                        <span id="grand-total">Rp 0</span>
                    </div>

                    <div class="flex justify-end pt-6">
                        <button type="submit"
                            class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-6 py-3">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let productsByOutlet = [];
        const cartContainer = document.getElementById('cart-container');
        const addProductBtn = document.getElementById('add-product-btn');
        const outletSelect = document.getElementById('outlet_id');
        const grandTotalEl = document.getElementById('grand-total');

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.product-row').forEach(row => {
                const selectedOption = row.querySelector('.product-select option:checked');
                const price = parseFloat(selectedOption.dataset.price || 0);
                const quantity = parseInt(row.querySelector('.quantity-input').value || 1);
                const subtotal = price * quantity;
                row.querySelector('.subtotal').textContent = formatRupiah(subtotal);
                total += subtotal;
            });
            grandTotalEl.textContent = formatRupiah(total);
        }

        function fetchProducts(outletId) {
            if (!outletId) {
                addProductBtn.disabled = true;
                return;
            }
            fetch(`{{ route('penjualan.produk.search') }}?outlet_id=${outletId}`)
                .then(response => response.json())
                .then(data => {
                    productsByOutlet = data;
                    addProductBtn.disabled = false;
                });
        }

        outletSelect.addEventListener('change', function () {
            cartContainer.innerHTML = '';
            calculateTotal();
            fetchProducts(this.value);
        });

        addProductBtn.addEventListener('click', function () {
            const productRow = document.createElement('div');
            productRow.className = 'product-row grid grid-cols-12 gap-4 items-center border-b pb-4';

            let options = '<option value="">-- Pilih Produk --</option>';
            productsByOutlet.forEach(p => {
                options += `<option value="${p.id}" data-price="${p.harga_jual}">${p.barang.nama} (Stok: ${p.stok})</option>`;
            });

            productRow.innerHTML = `
            <div class="col-span-5"><select name="products[]" class="product-select mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>${options}</select></div>
            <div class="col-span-2"><input type="number" name="quantities[]" class="quantity-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" min="1" value="1" required></div>
            <div class="col-span-2 text-sm">Harga: <span class="price-display">Rp 0</span></div>
            <div class="col-span-2 text-sm">Subtotal: <span class="subtotal font-semibold">Rp 0</span></div>
            <div class="col-span-1 text-right"><button type="button" class="remove-row-btn text-red-500 hover:text-red-700">X</button></div>
        `;
            cartContainer.appendChild(productRow);
        });

        cartContainer.addEventListener('change', function (e) {
            if (e.target.matches('.product-select, .quantity-input')) {
                const row = e.target.closest('.product-row');
                const selectedOption = row.querySelector('.product-select option:checked');
                const price = parseFloat(selectedOption.dataset.price || 0);
                row.querySelector('.price-display').textContent = formatRupiah(price);
                calculateTotal();
            }
        });

        cartContainer.addEventListener('click', function (e) {
            if (e.target.matches('.remove-row-btn')) {
                e.target.closest('.product-row').remove();
                calculateTotal();
            }
        });

        // Inisialisasi saat halaman dimuat (jika ada data lama dari validasi)
        if (outletSelect.value) {
            fetchProducts(outletSelect.value);
        }
    });
</script>