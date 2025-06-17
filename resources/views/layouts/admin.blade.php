<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Fintory Dashboard' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

            <nav
                class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="px-3 py-3 lg:px-5 lg:pl-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-start rtl:justify-end">
                            <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar"
                                type="button"
                                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                                <span class="sr-only">Open sidebar</span>
                                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                                    </path>
                                </svg>
                            </button>
                            <a href="/dashboard" class="flex ms-2 md:me-24">
                                <img src="{{ asset('images/logo-black.svg') }}" alt="Fintory Logo"
                                    class="h-10 me-3 block dark:hidden" />
                                <img src="{{ asset('images/logo.svg') }}" alt="Fintory Logo"
                                    class="h-10 me-3 hidden dark:block" />
                            </a>
                        </div>
                        <div class="flex items-center">
                            <div class="flex items-center ms-3">
                                <div>
                                    <button type="button"
                                        class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                        aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                        <span class="sr-only">Open user menu</span>
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ $lembaga->logo_path ? asset('storage/' . $lembaga->logo_path) : asset('images/avatar.png') }}"
                                            alt="lembaga logo">
                                    </button>
                                </div>
                                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm dark:bg-gray-700 dark:divide-gray-600"
                                    id="dropdown-user">
                                    <div class="px-4 py-3" role="none">
                                        <p class="text-sm text-gray-900 dark:text-white" role="none">
                                            {{ auth()->user()->getCurrentRole()->role_name ?? 'N/A' }}
                                        </p>
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300"
                                            role="none">
                                            {{ auth()->user()->email }}
                                        </p>
                                    </div>
                                    <ul class="py-1" role="none">
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                                role="menuitem">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('profile.edit') }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                                role="menuitem">Profile</a>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100
                       dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                                    role="menuitem">
                                                    Sign out
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <x-manager-sidebar />

            <div class="md:ml-[17rem] py-24">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div role="status" id="loader"
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5 flex justify-center">
                        <svg aria-hidden="true"
                            class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Terjadi Kesalahan!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
                    
                </div>

                <main id="main-content" class="hidden">
                    {!! $slot !!}
                </main>

            </div>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            let previousUrl = window.location.href;

            const DATATABLE_CONFIG = {
                language: {
                    processing: "Memproses...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                    infoFiltered: "(disaring dari _MAX_ total entri)",
                    loadingRecords: "Memuat...",
                    zeroRecords: "Tidak ada data yang cocok",
                    emptyTable: "Tidak ada data tersedia dalam tabel",
                },
                processing: true,
                serverSide: true
            };

            const PAGE_CONFIGS = {

                '/dashboard/saldo-outlet': {
                    url: '{{ route("saldo-outlet.data") }}',
                    columns: [
                        { data: 0, name: 'name', title: "Nama Outlet" },
                        { data: 1, name: 'address', title: "Alamat" },
                        { data: 2, name: 'balance', title: "Saldo", className: "text-right", orderable: false, searchable: false }
                    ]
                },

                '/dashboard/outlet-karyawan': {
                    url: '{{ route("outlet.data") }}',
                    columns: [
                        { data: 0, name: 'name', title: "Nama Outlet" },
                        { data: 1, name: 'address', title: "Alamat" },
                        { data: 2, name: 'phone', title: "No. Telp" },
                        { data: 3, name: 'action', title: "Aksi", orderable: false, searchable: false, className: "text-center" }
                    ]
                },
                
                    '/dashboard/outlet-karyawan/saldo': {
        url: '{{ route("outlet.saldo.data") }}',
        columns: [
            { data: 0, name: 'name', title: "Nama Outlet" },
            { data: 1, name: 'address', title: "Alamat" },
            { data: 2, name: 'balance', title: "Saldo", className: "text-right", orderable: false, searchable: false }
        ]
    },

                '/dashboard/keuangan/kas-ledger': {
                    url: '/dashboard/keuangan/kas-ledger/data',
                    columns: [{
                            data: 0,
                            title: "Tanggal"
                        },
                        {
                            data: 1,
                            title: "Tipe Transaksi"
                        },
                        {
                            data: 2,
                            title: "Sumber"
                        },
                        {
                            data: 3,
                            title: "Jumlah"
                        },
                        {
                            data: 4,
                            title: "Saldo Akhir"
                        },
                        {
                            data: 5,
                            title: "action"
                        }
                    ]
                },
                '/dashboard/keuangan/cicilan': {
                    url: '/dashboard/keuangan/cicilan/data',
                    columns: [{
                            data: 0,
                            title: "Tanggal Bayar"
                        },
                        {
                            data: 1,
                            title: "Pemberi Hutang"
                        },
                        {
                            data: 2,
                            title: "Jumlah Bayar"
                        },
                        {
                            data: 3,
                            title: "Sisa Hutang"
                        },
                        {
                            data: 4,
                            title: "Metode Pembayaran"
                        },
                        {
                            data: 5,
                            title: "Action"
                        }
                    ]
                },
                '/dashboard/keuangan/hutang': {
                    url: '/dashboard/keuangan/hutang/data',
                    columns: [{
                            data: 0,
                            title: "Tanggal"
                        },
                        {
                            data: 1,
                            title: "Outlet"
                        },
                        {
                            data: 2,
                            title: "Pemberi Hutang"
                        },
                        {
                            data: 3,
                            title: "Jumlah Hutang"
                        },
                        {
                            data: 4,
                            title: "Sisa Hutang"
                        },
                        {
                            data: 5,
                            title: "Action"
                        }
                    ]
                },
                '/dashboard/laporan/keuangan': {
                    url: '/dashboard/laporan/keuangan/data',
                    columns: [{
                            data: 0,
                            title: "Tanggal"
                        },
                        {
                            data: 1,
                            title: "Tipe"
                        },
                        {
                            data: 2,
                            title: "Sumber"
                        },
                        {
                            data: 3,
                            title: "Deskripsi"
                        },
                        {
                            data: 4,
                            title: "Jumlah"
                        },
                        {
                            data: 5,
                            title: "Saldo Setelah"
                        },
                        {
                            data: 6,
                            title: "Outlet"
                        },
                        {
                            data: 7,
                            title: "Detail"
                        }
                    ]
                },
                '/dashboard/laporan/stok/mutasi-stok': {
                    url: '/dashboard/laporan/stok/mutasi-stok/data',
                    columns: [{
                            data: 0,
                            title: "Tanggal"
                        },
                        {
                            data: 1,
                            title: "Outlet"
                        },
                        {
                            data: 2,
                            title: "Produk"
                        },
                        {
                            data: 3,
                            title: "Tipe"
                        },
                        {
                            data: 4,
                            title: "Jumlah"
                        },
                        {
                            data: 5,
                            title: "Detail"
                        }
                    ]
                },
                '/dashboard/laporan/stok/produk': {
                    url: '/dashboard/laporan/stok/produk/data',
                    columns: [{
                            data: 0,
                            title: "Tanggal"
                        },
                        {
                            data: 1,
                            title: "Barang"
                        },
                        {
                            data: 2,
                            title: "Kategori"
                        },
                        {
                            data: 3,
                            title: "Outlet"
                        },
                        {
                            data: 4,
                            title: "Harga Jual"
                        },
                        {
                            data: 5,
                            title: "Stok"
                        },
                        {
                            data: 6,
                            title: "Status"
                        },
                        {
                            data: 7,
                            title: "Detail"
                        }
                    ]
                },
                '/dashboard/produk-stok/barang': {
                    url: '/dashboard/produk-stok/barang/data',
                    columns: [{
                            data: 0,
                            title: "Nama"
                        },
                        {
                            data: 1,
                            title: "Deskripsi"
                        },
                        {
                            data: 2,
                            title: "action"
                        }
                    ]
                },
                '/dashboard/produk-stok/kategori': {
                    url: '/dashboard/produk-stok/kategori/data',
                    columns: [{
                            data: 0,
                            title: "Nama Kategori"
                        },
                        {
                            data: 1,
                            title: "Deskripsi"
                        },
                        {
                            data: 2,
                            title: "action"
                        }
                    ]
                },
                '/dashboard/produk-stok/produk': {
                    url: '/dashboard/produk-stok/produk/data',
                    columns: [{
                            data: 0,
                            title: "Nama Barang"
                        },
                        {
                            data: 1,
                            title: "Kategori"
                        },
                        {
                            data: 2,
                            title: "Outlet"
                        },
                        {
                            data: 3,
                            title: "Harga Jual"
                        },
                        {
                            data: 4,
                            title: "Stok"
                        },
                        {
                            data: 5,
                            title: "action"
                        }
                    ]
                },
                '/dashboard/produk-stok/mutasi': {
                    url: '/dashboard/produk-stok/mutasi/data',
                    columns: [{
                            data: 0,
                            title: "Tanggal"
                        },
                        {
                            data: 1,
                            title: "Produk"
                        },
                        {
                            data: 2,
                            title: "Outlet"
                        },
                        {
                            data: 3,
                            title: "Tipe"
                        },
                        {
                            data: 4,
                            title: "Kuantitas"
                        },
                        {
                            data: 5,
                            title: "Referensi"
                        }
                    ]
                },
                '/dashboard/penjualan/riwayat': {
                    url: '/dashboard/penjualan/riwayat/data',
                    columns: [{
                            data: 0,
                            title: "Tanggal"
                        },
                        {
                            data: 1,
                            title: "No. Transaksi"
                        },
                        {
                            data: 2,
                            title: "Outlet"
                        },
                        {
                            data: 3,
                            title: "Pelanggan"
                        },
                        {
                            data: 4,
                            title: "Total"
                        }
                    ]
                },

                '/dashboard/laporan/penjualan': {
                    url: '{{ route('laporan.penjualan.data') }}',
                    columns: [{
                            data: 0,
                            title: "Tanggal"
                        },
                        {
                            data: 1,
                            title: "No. Transaksi"
                        },
                        {
                            data: 2,
                            title: "Outlet"
                        },
                        {
                            data: 3,
                            title: "Pelanggan"
                        },
                        {
                            data: 4,
                            title: "Total",
                            className: "text-right"
                        },
                        {
                            data: 5,
                            title: "Aksi",
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        }
                    ]
                },
                '/dashboard/penjualan': {
                    url: '{{ route('penjualan.data') }}',
                    columns: [{
                            data: 0,
                            name: 'sale_date',
                            title: "Tanggal"
                        },
                        {
                            data: 1,
                            name: 'id',
                            title: "No. Transaksi"
                        },
                        {
                            data: 2,
                            name: 'outlet.name',
                            title: "Outlet"
                        },
                        {
                            data: 3,
                            name: 'customer_name',
                            title: "Pelanggan"
                        },
                        {
                            data: 4,
                            name: 'total',
                            title: "Total",
                            className: "text-right"
                        },
                        {
                            data: 5,
                            name: 'action',
                            title: "Aksi",
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        }
                    ]
                }
            };

            const Utils = {
                // Store event handler references for proper cleanup
                dateChangeHandlers: {
                    startDate: null,
                    endDate: null
                },

                // Add method to initialize date pickers
                initDatePickers() {
                    const dateRangeStartPicker = document.getElementById('datepicker-range-start');
                    const dateRangeEndPicker = document.getElementById('datepicker-range-end');

                    if (dateRangeStartPicker && dateRangeEndPicker) {
                        // Remove existing event listeners if they exist
                        if (this.dateChangeHandlers.startDate) {
                            dateRangeStartPicker.removeEventListener('changeDate', this.dateChangeHandlers.startDate);
                        }
                        if (this.dateChangeHandlers.endDate) {
                            dateRangeEndPicker.removeEventListener('changeDate', this.dateChangeHandlers.endDate);
                        }

                        // Reinitialize Flowbite datepicker components
                        if (typeof window.initDatePicker === 'function') {
                            window.initDatePicker('#datepicker-range-start');
                            window.initDatePicker('#datepicker-range-end');
                        } else {
                            // If using Flowbite directly, reinitialize the datepickers
                            try {
                                // Destroy existing Flowbite datepicker instances
                                if (dateRangeStartPicker._datepicker) {
                                    dateRangeStartPicker._datepicker.destroy();
                                }
                                if (dateRangeEndPicker._datepicker) {
                                    dateRangeEndPicker._datepicker.destroy();
                                }

                                // Reinitialize Flowbite components
                                if (typeof window.initFlowbite === 'function') {
                                    window.initFlowbite();
                                }
                            } catch (e) {
                                console.log('Flowbite datepicker cleanup/init error:', e);
                            }
                        }

                        // Store reference to current DataTable for reloading
                        let currentTable = null;
                        try {
                            if ($.fn.DataTable.isDataTable('#data-table')) {
                                currentTable = $('#data-table').DataTable();
                            }
                        } catch (e) {
                            console.log('DataTable reference error:', e);
                        }

                        // Create new event handlers
                        this.dateChangeHandlers.startDate = (e) => {
                            this.selectedStartDate = e.detail.date;
                            this.reloadDataTable(currentTable);
                        };

                        this.dateChangeHandlers.endDate = (e) => {
                            this.selectedEndDate = e.detail.date;
                            this.reloadDataTable(currentTable);
                        };

                        // Add fresh event listeners
                        dateRangeStartPicker.addEventListener('changeDate', this.dateChangeHandlers.startDate);
                        dateRangeEndPicker.addEventListener('changeDate', this.dateChangeHandlers.endDate);
                    }
                },

                // Separate method for reloading DataTable
                reloadDataTable(table) {
                    if (!table) return;

                    table.ajax.params = (d) => {
                        // Reset all custom parameters
                        delete d.start_date;
                        delete d.end_date;

                        // Add new parameters if dates are selected
                        if (this.selectedStartDate) {
                            d.start_date = this.selectedStartDate;
                        }
                        if (this.selectedEndDate) {
                            d.end_date = this.selectedEndDate;
                        }
                        return d;
                    };

                    table.ajax.reload();
                },

                initDataTable(pageType) {
                    const tableElement = document.getElementById("data-table");
                    if (!tableElement || !PAGE_CONFIGS[pageType]) return;

                    // Destroy existing DataTable
                    if ($.fn.DataTable.isDataTable('#data-table')) {
                        $('#data-table').DataTable().destroy();
                    }

                    const config = PAGE_CONFIGS[pageType];
                    config.columns.forEach(col => {
                        if (col.title && col.title.toLowerCase() === 'action') {
                            col.orderable = false;
                        }
                    });
                    const dataTableConfig = {
                        ...DATATABLE_CONFIG,
                        ajax: {
                            url: config.url,
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: (d) => {
                                // Add date range parameters to DataTable request
                                const dateRangeStartPicker = document.getElementById('datepicker-range-start');
                                const dateRangeEndPicker = document.getElementById('datepicker-range-end');

                                if (dateRangeStartPicker && dateRangeStartPicker.value) {
                                    d.start_date = dateRangeStartPicker.value;
                                }
                                if (dateRangeEndPicker && dateRangeEndPicker.value) {
                                    d.end_date = dateRangeEndPicker.value;
                                }
                                return d;
                            }
                        },
                        columns: config.columns
                    };

                    $('#data-table').DataTable(dataTableConfig);

                    // Initialize date pickers after DataTable is created
                    this.initDatePickers();
                },

                getPageType(url) {
                    const pathname = new URL(url, window.location.origin).pathname;
                    return PAGE_CONFIGS[pathname] ? pathname : null;
                },

                isHashOnlyChange(newUrl, currentUrl = window.location.href) {
                    const newUrlObj = new URL(newUrl);
                    const currentUrlObj = new URL(currentUrl);

                    newUrlObj.hash = '';
                    currentUrlObj.hash = '';

                    return newUrlObj.href === currentUrlObj.href;
                },

                handleHashNavigation(url) {
                    const hash = new URL(url).hash;
                    if (hash) {
                        const targetElement = document.querySelector(hash);
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                    }
                    history.pushState({}, '', url);
                },

                scrollToHash(hash, delay = 100) {
                    if (!hash) return;

                    setTimeout(() => {
                        const targetElement = document.querySelector(hash);
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                    }, delay);
                },

                // Enhanced page content loading with proper cleanup
                async loadPageContent(url) {
                    try {
                        const response = await fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (!response.ok) throw new Error(`HTTP ${response.status}`);

                        const html = await response.text();

                        // Clean up any existing components before loading new content
                        this.cleanupComponents();

                        const container = document.getElementById('main-content');

                        container.innerHTML = html;

                        // Initialize components for the new page
                        const pageType = this.getPageType(url);
                        if (pageType) {
                            // Add a small delay to ensure DO
                            this.initDataTable(pageType); // Increased delay for better reliability
                        } else {
                            // Still initialize date pi
                            this.initDatePickers();
                        }

                        const hash = new URL(url).hash;
                        this.scrollToHash(hash);
                        return true;
                    } catch (error) {
                        console.error('Failed to load page content:', error);
                        return false;
                    }
                },

                // Improved cleanup method
                cleanupComponents() {

                    // Destroy existing DataTable
                    if ($.fn.DataTable.isDataTable('#data-table')) {
                        $('#data-table').DataTable().destroy();
                    }

                    // Clear date picker references
                    this.selectedStartDate = null;
                    this.selectedEndDate = null;

                    // Clean up datepicker components
                    const datePickerElements = document.querySelectorAll('#datepicker-range-start, #datepicker-range-end');

                    datePickerElements.forEach((element, index) => {
                        // Remove existing event listeners using stored references
                        if (index === 0 && this.dateChangeHandlers.startDate) {
                            element.removeEventListener('changeDate', this.dateChangeHandlers.startDate);
                        }
                        if (index === 1 && this.dateChangeHandlers.endDate) {
                            element.removeEventListener('changeDate', this.dateChangeHandlers.endDate);
                        }

                        // Destroy Flowbite datepicker instance
                        if (element._datepicker && typeof element._datepicker.destroy === 'function') {
                            element._datepicker.destroy();
                        }

                        // Clear the input value
                        element.value = '';
                    });

                    // Clear stored event handlers
                    this.dateChangeHandlers.startDate = null;
                    this.dateChangeHandlers.endDate = null;
                },

                cleanCreateFormHandler() {
                    const form = document.getElementById('form-create');
                    if (form) {
                        // Clean up datepicker first
                        this.cleanCreateDatePicker();

                        // Remove existing event listeners by cloning
                        const newForm = form.cloneNode(true);
                        form.parentNode.replaceChild(newForm, form);

                        // Reset form input
                        newForm.reset();

                        // Remove error messages
                        newForm.querySelectorAll('.error-message').forEach(el => el.remove());

                        // Remove red border classes
                        newForm.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

                        // Reset submit button
                        const submitBtn = newForm.querySelector('#btn-submit');
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = 'Submit';
                            submitBtn.type = 'submit';
                        }
                    }
                },

                async initFormCreateHandler() {
                    // Clean existing handlers first
                    this.cleanCreateFormHandler();

                    const submitBtn = document.getElementById('btn-submit');

                    if (submitBtn) {
                        submitBtn.addEventListener('click', async (e) => {
                            e.preventDefault();

                            const form = document.getElementById('form-create');
                            console.log(form)
                            if (!form) return;

                            // Prevent double submission
                            if (submitBtn.disabled) {
                                return;
                            }

                            submitBtn.disabled = true;
                            submitBtn.innerHTML = `
                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                                Loading...
                            `;

                            try {
                                const response = await EventHandlers.makeAjaxRequest(form.action, 'POST',
                                    form);

                                submitBtn.disabled = false;
                                submitBtn.innerHTML = 'Submit';
                                if (typeof response === 'object' && response.redirect) {
                                    window.location.href = response.redirect;
                                } else if (typeof response === 'object' && response.message) {
                                    alert(response.message);
                                    form.reset();
                                } else if (typeof response === 'string') {
                                    console.log('HTML response received');
                                }

                            } catch (error) {
                                console.error('Error:', error);
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = 'Submit';
                                alert('An error occurred: ' + error.message);
                            }
                        });

                        // Initialize date picker (if needed)
                        this.initCreateDatePicker();
                    }
                },

                cleanCreateDatePicker() {
                    const tanggalPicker = document.getElementById('tanggal');

                    if (tanggalPicker) {
                        try {
                            // Remove event listener if exists
                            if (this.dateChangeHandlers?.tanggal) {
                                tanggalPicker.removeEventListener('changeDate', this.dateChangeHandlers.tanggal);
                                delete this.dateChangeHandlers.tanggal;
                            }

                            // Destroy datepicker instance if exists
                            if (tanggalPicker._datepicker) {
                                tanggalPicker._datepicker.destroy();
                                delete tanggalPicker._datepicker;
                            }

                            // Clean up any other datepicker properties
                            if (tanggalPicker._flatpickr) {
                                tanggalPicker._flatpickr.destroy();
                                delete tanggalPicker._flatpickr;
                            }
                        } catch (e) {
                            console.log('Clean up error for Tanggal Hutang datepicker:', e);
                        }
                    }
                },

                initCreateDatePicker() {
                    const tanggalPicker = document.getElementById('tanggal');

                    if (tanggalPicker) {
                        // Clean up first
                        this.cleanCreateDatePicker();

                        // Wait a bit for cleanup to complete
                        setTimeout(() => {
                            try {
                                if (typeof window.initDatePicker === 'function') {
                                    window.initDatePicker('#tanggal');
                                } else if (typeof window.initFlowbite === 'function') {
                                    window.initFlowbite();
                                }
                            } catch (e) {
                                console.log('Init error for Tanggal Hutang datepicker:', e);
                            }

                            // Initialize date change handlers
                            if (!this.dateChangeHandlers) {
                                this.dateChangeHandlers = {};
                            }

                            this.dateChangeHandlers.tanggal = (e) => {
                                this.selectedtanggal = e.detail.date;
                            };

                            tanggalPicker.addEventListener('changeDate', this.dateChangeHandlers.tanggal);
                        }, 100);
                    }
                },

                initFormEditHandler() {
                    // Wait for the form to be available in the DOM
                    const waitForForm = () => {
                        const form = document.getElementById('form-edit');
                        if (form) {
                            // Set form attributes
                            form.method = 'POST';

                            const submitBtn = form.querySelector('#btn-submit');

                            form.addEventListener('submit', async (e) => {
                                e.preventDefault();

                                if (submitBtn.disabled) return;

                                submitBtn.disabled = true;
                                submitBtn.innerHTML = `
                                    <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                    </svg>
                                    Loading...
                                `;

                                try {
                                    const response = await fetch(form.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').content,
                                            'Accept': 'application/json',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                        body: new FormData(form)
                                    });

                                    const result = await response.json();

                                    submitBtn.disabled = false;
                                    submitBtn.innerHTML = 'Update';
                                    if (result.redirect) {
                                        window.location.href = result.redirect;
                                    } else if (result.message) {
                                        alert(result.message);
                                    }

                                } catch (error) {
                                    console.error('Error:', error);
                                    submitBtn.disabled = false;
                                    submitBtn.innerHTML = 'Update';
                                    alert('An error occurred: ' + error.message);
                                }
                            });
                        } else {
                            // Retry after a short delay if form not found
                            setTimeout(waitForForm, 100);
                        }
                    };

                    waitForForm();
                }
            };

            // Event Handlers
            // Enhanced Event Handlers dengan dukungan multiple link types
            const EventHandlers = {
                linkConfigs: {
                    
                    '.menu-link': {
                        method: 'GET',
                        loadIntoContainer: '#main-content',
                        showLoader: true,
                        updateHistory: true,
                        updateTitle: true,
                        onSuccess: (response, element) => {
                            // Jika masuk ke /dashboard, lakukan refresh
                            const url = element.href || element.getAttribute('data-url');
                            if (url) {
                                const pathname = new URL(url, window.location.origin).pathname;
                                if (pathname === '/dashboard') {
                                    window.location.reload();
                                }
                            }
                        }
                    },
                    '.create-link': {
                        method: 'GET',
                        loadIntoContainer: '#main-content',
                        showLoader: true,
                        updateHistory: true,
                        updateTitle: true,
                        afterLoad: () => {
                            // Pastikan DOM sudah siap sebelum inisialisasi
                            setTimeout(() => {
                                if (typeof Utils !== 'undefined' && Utils.initFormCreateHandler) {
                                    Utils.initFormCreateHandler();
                                }
                            }, 150);
                        }
                    },
                    '.edit-link': {
                        method: 'GET',
                        loadIntoContainer: '#main-content',
                        showLoader: true,
                        updateHistory: true,
                        updateTitle: true,
                        afterLoad: (response, element) => {
                            // Use MutationObserver to wait for dynamic content
                            const observer = new MutationObserver((mutations, obs) => {
                                const form = document.getElementById('form-edit');
                                if (form) {
                                    Utils.initFormEditHandler();

                                    // Initialize datepicker
                                    const tanggalInput = document.getElementById('tanggal');
                                    if (tanggalInput) {
                                        if (tanggalInput._datepicker) {
                                            tanggalInput._datepicker.destroy();
                                        }

                                        const datepickerInstance = new Datepicker(tanggalInput, {
                                            format: "yyyy/mm/dd",
                                            autohide: true,
                                            buttons: true
                                        });

                                        if (tanggalInput.value) {
                                            datepickerInstance.setDate(new Date(tanggalInput.value));
                                        }
                                    }

                                    obs.disconnect(); // Stop observing once done
                                }
                            });

                            observer.observe(document.getElementById('main-content'), {
                                childList: true,
                                subtree: true
                            });
                        }
                    },
                    '.confirm-delete': {
                        method: 'DELETE',
                        requireConfirmation: true, // Ini akan memicu dialog konfirmasi
                        confirmMessage: 'Apakah Anda yakin ingin menghapus data ini?',
                        showLoader: false, // Tidak perlu loader besar untuk aksi cepat
                        onSuccess: (response, element) => {
                            if (typeof $ !== 'undefined' && $.fn.DataTable.isDataTable('#data-table')) {
                                $('#data-table').DataTable().ajax.reload(null, false);
                            }
                            if (typeof Swal !== 'undefined') {
                                Swal.fire('Berhasil!', response.message || 'Data berhasil dihapus.', 'success');
                            } else {
                                alert(response.message || 'Data berhasil dihapus.');
                            }
                        },
                        onError: (error, element) => {
                            let message = 'Terjadi kesalahan saat menghapus data.';
                            if (error.response && typeof error.response.json === 'function') {
                                error.response.json().then(json => {
                                    if (json.message) message = json.message;
                                    if (typeof Swal !== 'undefined') Swal.fire('Gagal!', message, 'error');
                                    else alert(message);
                                }).catch(() => {
                                    if (typeof Swal !== 'undefined') Swal.fire('Gagal!', message, 'error');
                                    else alert(message);
                                });
                            } else {
                                if (typeof Swal !== 'undefined') Swal.fire('Gagal!', message, 'error');
                                else alert(message);
                            }
                        }
                    },
                    '.ajax-link': {
                        method: 'GET',
                        loadIntoContainer: '#main-content',
                        showLoader: true,
                        updateHistory: false,
                        updateTitle: false
                    },
                    '.modal-link': {
                        method: 'GET',
                        loadIntoContainer: '#modal-content',
                        showLoader: false,
                        updateHistory: false,
                        updateTitle: false,
                        afterLoad: (response, element) => {
                            const modal = document.getElementById('modal');
                            if (modal) {
                                modal.classList.remove('hidden');
                            }
                        }
                    }
                },

                // Method untuk menentukan konfigurasi link
                getLinkConfig(element) {
                    for (const [selector, config] of Object.entries(this.linkConfigs)) {
                        if (element.matches(selector) || element.closest(selector)) {
                            return {
                                selector,
                                ...config
                            };
                        }
                    }
                    return null;
                },

                // Enhanced handle click untuk semua jenis link
                async handleLinkClick(e) {
                    const clickedElement = e.target;
                    // Cari elemen yang cocok dengan konfigurasi di linkConfigs
                    const linkElement = Object.keys(this.linkConfigs).reduce((acc, selector) => acc || clickedElement.closest(selector), null);

                    if (!linkElement) return;

                    const config = this.getLinkConfig(linkElement);
                    if (!config) return;

                    e.preventDefault();
                    e.stopPropagation();

                    const url = linkElement.href || linkElement.getAttribute('data-url');
                    if (!url) return;

                    // Handle konfirmasi (sekarang dengan SweetAlert) jika diperlukan
                    if (config.requireConfirmation) {
                        try {
                            const result = await Swal.fire({
                                title: config.confirmMessage || 'Anda yakin?',
                                text: "Tindakan ini tidak dapat dibatalkan!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: 'Ya, Lanjutkan!',
                                cancelButtonText: 'Batal'
                            });
                            if (!result.isConfirmed) {
                                return; // Berhenti jika pengguna menekan "Batal"
                            }
                        } catch (error) {
                            console.error("SweetAlert error:", error);
                            return; // Berhenti jika ada error
                        }
                    }

                    try {
                        if (config.showLoader) this.showLoader();
                        const response = await this.makeAjaxRequest(url, config.method, linkElement);

                        if (config.method === 'GET' && config.loadIntoContainer) {
                            await this.loadContentIntoContainer(response, config.loadIntoContainer, url);
                        }
                        if (config.updateHistory) {
                            history.pushState({}, '', url);
                        }
                        if (config.updateTitle) {
                            document.title = linkElement.getAttribute('data-title') || document.title;
                        }
                        if (config.onSuccess) await config.onSuccess(response, linkElement);
                        if (config.afterLoad) await config.afterLoad(response, linkElement);

                    } catch (error) {
                        console.error('Request failed:', error);
                        if (config.onError) {
                            await config.onError(error, linkElement);
                        } else {
                            alert('Terjadi kesalahan.');
                        }
                    } finally {
                        if (config.showLoader) this.hideLoader();
                    }
                },                // Method untuk melakukan AJAX request
                async makeAjaxRequest(url, method = 'GET', element = null) {
                    const options = {
                        method: method,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    };

                    // Hanya proses FormData jika element ada di dalam sebuah form
                    // Ini akan memperbaiki tombol Hapus yang tidak berada di dalam form
                    const form = element ? element.closest('form') : null;
                    if (form && ['POST', 'PUT', 'PATCH'].includes(method)) {
                        options.body = new FormData(form);
                    }

                    const response = await fetch(url, options);

                    if (!response.ok) {
                        const error = new Error(`HTTP ${response.status}: ${response.statusText}`);
                        error.response = response; // Lampirkan response ke error untuk penanganan lebih baik
                        throw error;
                    }

                    // Return response berdasarkan content type
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return await response.json();
                    } else if (response.redirected && response.url) {
                        window.location.href = response.url;
                        return;
                    } else {
                        return await response.text();
                    }
                },

                // Method untuk load content ke container
                async loadContentIntoContainer(content, containerSelector, url) {
                    const container = document.querySelector(containerSelector);
                    if (!container) {
                        throw new Error(`Container ${containerSelector} not found`);
                    }

                    // Clean up existing components
                    Utils.cleanupComponents();

                    // Load new content
                    if (typeof content === 'string') {
                        container.innerHTML = content;
                    } else {
                        // Handle JSON response
                        if (content.html) {
                            container.innerHTML = content.html;
                        }
                    }

                    // Initialize components untuk halaman baru
                    const pageType = Utils.getPageType(url);
                    if (pageType) {
                        Utils.initDataTable(pageType);
                    } else {
                        Utils.initDatePickers();
                    }

                    // Handle hash navigation
                    const hash = new URL(url, window.location.origin).hash;
                    if (hash) {
                        Utils.scrollToHash(hash);
                    }

                    // Reinitialize Flowbite components
                    if (typeof window.initFlowbite === 'function') {
                        window.initFlowbite();
                    }
                },

                // Method untuk show/hide loader
                showLoader() {
                    const loader = document.getElementById('loader');
                    const mainContent = document.getElementById('main-content');

                    if (loader) loader.classList.remove('hidden');
                    if (mainContent) mainContent.classList.add('hidden');
                },

                hideLoader() {
                    const loader = document.getElementById('loader');
                    const mainContent = document.getElementById('main-content');

                    if (loader) loader.classList.add('hidden');
                    if (mainContent) mainContent.classList.remove('hidden');
                },

                // Handle form submission via AJAX
                async handleFormSubmit(e) {
                    const form = e.target;

                    // Cek apakah form memiliki class ajax-form
                    if (!form.classList.contains('ajax-form')) return;

                    e.preventDefault();

                    const url = form.action;
                    const method = form.method.toUpperCase();
                    const formData = new FormData(form);

                    try {
                        this.showLoader();

                        const response = await fetch(url, {
                            method: method,
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                    'content') || ''
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}`);
                        }

                        const result = await response.json();

                        // Handle success response
                        if (result.success) {
                            // Redirect jika ada redirect URL
                            if (result.redirect) {
                                await this.loadContentIntoContainer(
                                    await this.makeAjaxRequest(result.redirect),
                                    '#main-content',
                                    result.redirect
                                );
                                history.pushState({}, '', result.redirect);
                            }

                            // Reload DataTable jika ada
                            if ($.fn.DataTable.isDataTable('#data-table')) {
                                $('#data-table').DataTable().ajax.reload();
                            }

                            // Show success message
                            if (result.message) {
                                alert(result.message);
                            }
                        } else {
                            // Handle validation errors
                            this.handleFormErrors(form, result.errors || {});
                        }

                    } catch (error) {
                        console.error('Form submission failed:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    } finally {
                        this.hideLoader();
                    }
                },

                // Handle form validation errors
                handleFormErrors(form, errors) {
                    // Clear previous errors
                    form.querySelectorAll('.error-message').forEach(el => el.remove());
                    form.querySelectorAll('.border-red-500').forEach(el => {
                        el.classList.remove('border-red-500');
                    });

                    // Display new errors
                    Object.keys(errors).forEach(fieldName => {
                        const field = form.querySelector(`[name="${fieldName}"]`);
                        if (field) {
                            field.classList.add('border-red-500');

                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'error-message text-red-500 text-sm mt-1';
                            errorDiv.textContent = errors[fieldName][0];

                            field.parentNode.appendChild(errorDiv);
                        }
                    });
                },

                // Handle browser back/forward navigation
                handlePopState(event) {
                    const currentUrl = window.location.href;

                    if (Utils.isHashOnlyChange(currentUrl, previousUrl)) {
                        const hash = new URL(currentUrl).hash;
                        Utils.scrollToHash(hash);
                        previousUrl = currentUrl;
                        return;
                    }

                    this.showLoader();

                    this.makeAjaxRequest(currentUrl)
                        .then(content => {
                            this.loadContentIntoContainer(
                                content,
                                '#main-content',
                                currentUrl
                            );
                        })
                        .catch(error => {
                            console.error('Failed to load page:', error);
                            window.location.reload();
                        })
                        .finally(() => {
                            this.hideLoader();
                            previousUrl = currentUrl;
                        });
                },

                // Handle initial page load
                handleDOMContentLoaded() {
                    const pageType = Utils.getPageType(location.href);
                    if (pageType) {
                        Utils.initDataTable(pageType);
                    } else {
                        Utils.initDatePickers();
                    }

                    Utils.scrollToHash(window.location.hash);
                },

                // Handle window load
                handleWindowLoad() {
                    this.hideLoader();
                }
            };

            // Initialize Event Listeners dengan delegation untuk semua jenis link
            document.body.addEventListener('click', EventHandlers.handleLinkClick.bind(EventHandlers));
            document.body.addEventListener('submit', EventHandlers.handleFormSubmit.bind(EventHandlers), true);
            window.addEventListener('popstate', EventHandlers.handlePopState.bind(EventHandlers));
            document.addEventListener('DOMContentLoaded', EventHandlers.handleDOMContentLoaded.bind(EventHandlers));
            window.addEventListener('load', EventHandlers.handleWindowLoad.bind(EventHandlers));

            document.addEventListener('DOMContentLoaded', () => {
                const selected_outlet = document.getElementById('outlet-select');
                if (selected_outlet) {
                    selected_outlet.addEventListener('change', function() {
                        const outletId = this.value;
                        fetch('/dashboard/set-outlet', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .content,
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    selected_outlet_id: outletId
                                })
                            })
                            .then(response => {
                                console.log(response)
                                if (!response.ok) throw new Error(response);
                                return response.json();
                            })
                            .then(data => {
                                // Reload DataTable jika ada
                                if ($.fn.DataTable.isDataTable('#data-table')) {
                                    $('#data-table').DataTable().ajax.reload();
                                }
                                const current_selected_outlet_name = document.getElementById(
                                    'current_selected_outlet_name');

                                if (current_selected_outlet_name) {
                                    const outletName = this.options[this.selectedIndex].text
                                    current_selected_outlet_name.innerHTML = outletName == "All Outlets" ?
                                        "Semua Outlet" : outletName;
                                }

                                const totalHutang = document.getElementById('totalHutang')
                                const totalSaldo = document.getElementById('totalSaldo')

                                // Jika kedua elemen ada, lakukan AJAX request ke URL saat ini
                                if (totalHutang && totalSaldo) {
                                    fetch(window.location.href, {
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest'
                                            }
                                        })
                                        .then(response => response.text())
                                        .then(html => {
                                            // Buat elemen dummy untuk parsing HTML
                                            const parser = new DOMParser();
                                            const doc = parser.parseFromString(html, 'text/html');
                                            // Ambil nilai terbaru dari response
                                            const newTotalHutang = doc.getElementById('totalHutang');
                                            const newTotalSaldo = doc.getElementById('totalSaldo');
                                            if (newTotalHutang) totalHutang.innerHTML = newTotalHutang
                                                .innerHTML;
                                            if (newTotalSaldo) totalSaldo.innerHTML = newTotalSaldo
                                                .innerHTML;
                                        })
                                        .catch(error => {
                                            console.error('Gagal update total hutang/saldo:', error);
                                        });
                                }
                            })
                            .catch(error => {
                                alert(error);
                            });
                    });
                }
            })

            // Jalankan chart hanya jika di halaman /dashboard
            document.addEventListener("DOMContentLoaded", () => {
                if (window.location.pathname === "/dashboard") {
                    // Area Chart: Penjualan 7 Hari Terakhir
                    fetch("/api/sales-last-7-days")
                        .then(response => response.json())
                        .then(data => {
                            const dates = data.map(item => item.date);
                            const totals = data.map(item => item.total);

                            const options = {
                                chart: {
                                    height: "100%",
                                    width: "100%",
                                    type: "area",
                                    fontFamily: "Inter, sans-serif",
                                    toolbar: {
                                        show: false
                                    },
                                    dropShadow: {
                                        enabled: false
                                    },
                                },
                                tooltip: {
                                    enabled: true,
                                    x: {
                                        show: true
                                    },
                                },
                                fill: {
                                    type: "gradient",
                                    gradient: {
                                        opacityFrom: 0.55,
                                        opacityTo: 0,
                                        shade: "#1C64F2",
                                        gradientToColors: ["#1C64F2"],
                                    },
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    width: 6
                                },
                                grid: {
                                    show: false,
                                    strokeDashArray: 4,
                                    padding: {
                                        left: 2,
                                        right: 2,
                                        top: 0
                                    },
                                },
                                series: [{
                                    name: "Sales",
                                    data: totals,
                                    color: "#1A56DB",
                                }],
                                xaxis: {
                                    categories: dates,
                                    labels: {
                                        show: true
                                    },
                                    axisBorder: {
                                        show: false
                                    },
                                    axisTicks: {
                                        show: true
                                    },
                                },
                                yaxis: {
                                    show: true
                                },
                            };

                            const el = document.getElementById("area-chart");
                            if (el && typeof ApexCharts !== 'undefined') {
                                const chart = new ApexCharts(el, options);
                                chart.render();
                            }
                        })
                        .catch(error => {
                            console.error("Error fetching chart data:", error);
                        });

                    // Bar Chart: Produk Terlaris
                    fetch('/api/best-seller-products')
                        .then(response => response.json())
                        .then(data => {
                            const products = data.products || [];

                            if (products.length === 0) {
                                document.getElementById('no-product-info').classList.remove('hidden');
                                return;
                            }

                            const categories = products.map(p => p.name);
                            const quantities = products.map(p => p.qty);

                            const options = {
                                series: [{
                                    name: "Jumlah Terjual",
                                    data: quantities,
                                }],
                                chart: {
                                    type: "bar",
                                    height: 400,
                                    toolbar: {
                                        show: false
                                    }
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: true,
                                        borderRadius: 4,
                                        barHeight: '60%',
                                        distributed: true
                                    }
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899'],
                                xaxis: {
                                    categories: categories,
                                    labels: {
                                        style: {
                                            fontFamily: "Inter, sans-serif",
                                            fontSize: "14px",
                                            colors: "#6B7280"
                                        }
                                    },
                                    title: {
                                        text: "Jumlah Terjual",
                                        style: {
                                            fontWeight: 600,
                                            fontSize: "14px"
                                        }
                                    }
                                },
                                yaxis: {
                                    labels: {
                                        style: {
                                            fontFamily: "Inter, sans-serif",
                                            fontSize: "14px",
                                            fontWeight: 500,
                                            colors: "#374151"
                                        }
                                    }
                                },
                                tooltip: {
                                    y: {
                                        formatter: function(val) {
                                            return val + " unit";
                                        }
                                    }
                                },
                                grid: {
                                    borderColor: "#E5E7EB",
                                    strokeDashArray: 4
                                }
                            };

                            const chart = new ApexCharts(document.querySelector("#bar-chart"), options);
                            chart.render();
                        })
                        .catch(error => {
                            console.error('Gagal mengambil data produk terlaris:', error);
                            document.getElementById('no-product-info').classList.remove('hidden');
                        });
                }
            });
        </script>

        <script>
            $(document).ready(function () {
                // Handler umum untuk tombol delete atau toggle
                $(document).on('click', '.delete-btn, .toggle-status-product-btn', function (e) {
                    e.preventDefault();

                    const $button = $(this);
                    const url = $button.data('url');
                    const action = $button.data('action') || 'delete'; // 'delete', 'non-active', 'active'
                    const id = $button.data('id');

                    // Tentukan konfigurasi berdasarkan aksi
                    let config = {
                        title: 'Anda yakin?',
                        text: '',
                        icon: 'warning',
                        confirmText: 'Ya, lanjutkan!',
                        successMessage: 'Aksi berhasil dilakukan.',
                        errorMessage: 'Terjadi kesalahan.',
                    };

                    if (action === 'delete') {
                        config.text = "Data yang dihapus tidak dapat dikembalikan!";
                        config.confirmText = 'Ya, hapus!';
                        config.successMessage = 'Data berhasil dihapus.';
                        config.errorMessage = 'Gagal menghapus data.';
                    } else if (action === 'non-active') {
                        config.text = "Produk akan dinonaktifkan dari daftar.";
                        config.confirmText = 'Ya, nonaktifkan!';
                        config.successMessage = 'Produk berhasil dinonaktifkan.';
                        config.errorMessage = 'Gagal menonaktifkan produk.';
                    } else if (action === 'active') {
                        config.text = "Produk akan diaktifkan kembali.";
                        config.confirmText = 'Ya, aktifkan!';
                        config.successMessage = 'Produk berhasil diaktifkan.';
                        config.errorMessage = 'Gagal mengaktifkan produk.';
                    }

                    Swal.fire({
                        title: config.title,
                        text: config.text,
                        icon: config.icon,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: config.confirmText,
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: (action === 'delete') ? 'DELETE' : 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    id: id
                                },
                                success: function (response) {
                                    if (response.success) {
                                        Swal.fire(
                                            'Berhasil!',
                                            response.message || config.successMessage,
                                            'success'
                                        );
                                        if (window.dataTable) {
                                            window.dataTable.draw(false);
                                        } else if (typeof $('#data-table').DataTable === 'function') {
                                            $('#data-table').DataTable().ajax.reload(null, false);
                                        }
                                    } else if (response.requiresConfirmation) {
                                        Swal.fire({
                                            title: 'Data Terkait Ditemukan!',
                                            text: response.message || 'Data outlet ini memiliki relasi. Hapus semua data yang terkait?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Ya, hapus semua!',
                                            cancelButtonText: 'Batal',
                                            confirmButtonColor: '#e3342f'
                                        }).then((confirmResult) => {
                                            if (confirmResult.isConfirmed) {
                                                $.ajax({
                                                    url: url,
                                                    type: 'DELETE',
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    data: {
                                                        id: id,
                                                        force: true // Kirim ulang dengan force delete
                                                    },
                                                    success: function (res) {
                                                        Swal.fire('Berhasil!', res.message, 'success');
                                                        if (window.dataTable) {
                                                            window.dataTable.draw(false);
                                                        } else if (typeof $('#data-table').DataTable === 'function') {
                                                            $('#data-table').DataTable().ajax.reload(null, false);
                                                        }
                                                    },
                                                    error: function () {
                                                        Swal.fire('Error!', 'Gagal menghapus secara paksa.', 'error');
                                                    }
                                                });
                                            }
                                        });
                                    } else {
                                        Swal.fire(
                                            'Gagal!',
                                            response.message || config.errorMessage,
                                            'error'
                                        );
                                    }
                                },
                                error: function (xhr) {
                                    let errorMessage = config.errorMessage;
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMessage = xhr.responseJSON.message;
                                    }
                                    Swal.fire(
                                        'Error!',
                                        errorMessage,
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            });
        </script>

    </body>

</html>
