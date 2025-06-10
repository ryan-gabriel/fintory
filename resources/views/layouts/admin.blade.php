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
                                            <a href="#"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                                role="menuitem">Earnings</a>
                                        </li>
                                        <li>
                                            <!-- Replace the old <a>Sign out</a> with this form: -->
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
                    <div role="status" id="loader" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5 flex justify-center">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
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

        <script>
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
                }
            };

            // Event Handlers
            // Enhanced Event Handlers dengan dukungan multiple link types
            const EventHandlers = {
                // Konfigurasi untuk berbagai jenis link
                linkConfigs: {
                    '.menu-link': {
                        method: 'GET',
                        loadIntoContainer: '#main-content',
                        showLoader: true,
                        updateHistory: true,
                        updateTitle: true
                    },
                    '.create-link': {
                        method: 'GET',
                        loadIntoContainer: '#main-content',
                        showLoader: true,
                        updateHistory: true,
                        updateTitle: true,
                    },
                    '.edit-link': {
                        method: 'GET',
                        loadIntoContainer: '#main-content',
                        showLoader: true,
                        updateHistory: true,
                        updateTitle: true,
                    },
                    '.delete-link': {
                        method: 'DELETE',
                        requireConfirmation: true,
                        confirmMessage: 'Apakah Anda yakin ingin menghapus data ini?',
                        onSuccess: (response, element) => {
                            if ($.fn.DataTable.isDataTable('#data-table')) {
                                $('#data-table').DataTable().ajax.reload();
                            }
                            // Show success message
                            alert('Data berhasil dihapus');
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
                            // Show modal after content loaded
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
                    // If the clicked link is a hash-only navigation, just scroll to the section without AJAX
                    const nextUrl = e.target.closest('a')?.href || e.target.getAttribute('data-url');
                    if (nextUrl && Utils.isHashOnlyChange(nextUrl, window.location.href)) {
                        console.log('nextUrl:', nextUrl);

                        const hash = new URL(nextUrl, window.location.origin).hash;
                        if (hash) {
                            Utils.scrollToHash(hash);
                            // Update the URL hash in the address bar
                            history.pushState({}, '', nextUrl);
                        }
                        e.preventDefault();
                        e.stopPropagation();
                        return;
                    }
                    const clickedElement = e.target;
                    let linkElement = null;
                    let config = null;

                    // Cari link element dan konfigurasinya
                    for (const selector of Object.keys(this.linkConfigs)) {
                        const found = clickedElement.closest(selector);
                        if (found) {
                            linkElement = found;
                            config = this.getLinkConfig(found);
                            break;
                        }
                    }

                    // Jika tidak ada link yang cocok, return
                    if (!linkElement || !config) return;

                    e.preventDefault();
                    e.stopPropagation();

                    const url = linkElement.href || linkElement.getAttribute('data-url');
                    if (!url) return;

                    try {
                        // Konfirmasi jika diperlukan
                        if (config.requireConfirmation) {
                            const confirmed = confirm(config.confirmMessage || 'Apakah Anda yakin?');
                            if (!confirmed) return;
                        }

                        // Execute beforeLoad callback
                        if (config.beforeLoad) {
                            await config.beforeLoad(url, linkElement);
                        }

                        // Show loader jika diperlukan
                        if (config.showLoader) {
                            this.showLoader();
                        }

                        // Lakukan AJAX request
                        const response = await this.makeAjaxRequest(url, config.method, linkElement);

                        // Handle response berdasarkan method
                        if (config.method === 'GET' && config.loadIntoContainer) {
                            await this.loadContentIntoContainer(response, config.loadIntoContainer, url);
                        }

                        // Update history jika diperlukan
                        if (config.updateHistory) {
                            history.pushState({}, '', url);
                        }

                        // Update title jika diperlukan
                        if (config.updateTitle) {
                            const newTitle = linkElement.getAttribute('data-title');
                            if (newTitle) {
                                document.title = newTitle;
                            }
                        }

                        // Execute success callback
                        if (config.onSuccess) {
                            await config.onSuccess(response, linkElement);
                        }

                        // Execute afterLoad callback
                        if (config.afterLoad) {
                            await config.afterLoad(response, linkElement);
                        }

                    } catch (error) {
                        console.error('AJAX request failed:', error);

                        // Execute error callback jika ada
                        if (config.onError) {
                            await config.onError(error, linkElement);
                        } else {
                            console.log(error)
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    } finally {
                        // Hide loader
                        if (config.showLoader) {
                            this.hideLoader();
                        }
                    }
                },

                // Method untuk melakukan AJAX request
                async makeAjaxRequest(url, method = 'GET', element = null) {
                    const options = {
                        method: method,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                'content') || ''
                        }
                    };

                    // Jika method POST/PUT/PATCH, tambahkan Content-Type
                    if (['POST', 'PUT', 'PATCH'].includes(method)) {
                        options.headers['Content-Type'] = 'application/json';
                    }

                    // Handle form data jika link ada di dalam form
                    if (method !== 'GET' && element) {
                        const form = element.closest('form');
                        if (form) {
                            const formData = new FormData(form);
                            options.body = formData;
                            delete options.headers['Content-Type']; // Let browser set it for FormData
                        }
                    }

                    const response = await fetch(url, options);

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }

                    // Return response berdasarkan content type
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return await response.json();
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
                handlePopState() {
                    const url = location.href;
                    const referrer = document.referrer;
                    
                    // Handle hash-only changes - don't reload content
                    if (referrer && Utils.isHashOnlyChange(url, referrer)) {
                        const hash = new URL(url).hash;
                        Utils.scrollToHash(hash);
                        return;
                    }

                    // Only load content if it's not a hash-only change
                    this.loadContentIntoContainer(
                        this.makeAjaxRequest(url),
                        '#main-content',
                        url
                    );
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
            document.body.addEventListener('click', EventHandlers.handleLinkClick.bind(EventHandlers), true);
            document.body.addEventListener('submit', EventHandlers.handleFormSubmit.bind(EventHandlers), true);
            window.addEventListener('popstate', EventHandlers.handlePopState.bind(EventHandlers));
            document.addEventListener('DOMContentLoaded', EventHandlers.handleDOMContentLoaded.bind(EventHandlers));
            window.addEventListener('load', EventHandlers.handleWindowLoad.bind(EventHandlers));
        </script>
    </body>

</html>
