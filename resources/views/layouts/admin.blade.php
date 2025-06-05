<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Fintory Dashboard' }}</title>

    <!-- Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        
        <!-- Navigation Bar -->
        <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    
                    <!-- Left Side - Logo & Menu Toggle -->
                    <div class="flex items-center justify-start rtl:justify-end">
                        <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" 
                                aria-controls="sidebar" type="button"
                                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                            <span class="sr-only">Open sidebar</span>
                            <i class="fas fa-bars w-6 h-6"></i>
                        </button>
                        
                        <a href="/dashboard" class="flex ms-2 md:me-24">
                            <img src="{{ asset('images/logo-black.svg') }}" alt="Fintory Logo"
                                 class="h-10 me-3 block dark:hidden" />
                            <img src="{{ asset('images/logo.svg') }}" alt="Fintory Logo"
                                 class="h-10 me-3 hidden dark:block" />
                        </a>
                    </div>
                    
                    <!-- Right Side - User Menu -->
                    <div class="flex items-center ms-3">
                        <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full"
                                 src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                 alt="user photo">
                        </button>
                        
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm dark:bg-gray-700 dark:divide-gray-600"
                             id="dropdown-user">
                            <div class="px-4 py-3">
                                <p class="text-sm text-gray-900 dark:text-white">Neil Sims</p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300">
                                    neil.sims@flowbite.com
                                </p>
                            </div>
                            <ul class="py-1">
                                <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a></li>
                                <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a></li>
                                <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a></li>
                                <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <x-manager-sidebar />

        <!-- Main Content -->
        <div class="md:ml-[17rem] py-24">
            <div id="loader" class="flex justify-center items-center h-32 bg-white dark:bg-gray-800">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-600 dark:border-white dark:text-white"></div>
                <span class="ml-2 text-gray-600">Loading...</span>
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
        columns: [
            { data: 0, title: "Tanggal" },
            { data: 1, title: "Tipe Transaksi" },
            { data: 2, title: "Sumber" },
            { data: 3, title: "Jumlah" },
            { data: 4, title: "Saldo Akhir" }
        ]
    },
    '/dashboard/keuangan/cicilan': {
        url: '/dashboard/keuangan/cicilan/data',
        columns: [
            { data: 0, title: "Tanggal Bayar" },
            { data: 1, title: "Pemberi Hutang" },
            { data: 2, title: "Jumlah Bayar" },
            { data: 3, title: "Sisa Hutang" },
            { data: 4, title: "Metode Pembayaran" },
        ]
    },
    '/dashboard/keuangan/hutang': {
        url: '/dashboard/keuangan/hutang/data',
        columns: [
            { data: 0, title: "Tanggal" },
            { data: 1, title: "Outlet" },
            { data: 2, title: "Pemberi Hutang" },
            { data: 3, title: "Jumlah Hutang" },
            { data: 4, title: "Sisa Hutang" },
        ]
    }
};

const Utils = {
    // Add method to initialize date pickers
    initDatePickers() {
        const dateRangeStartPicker = document.getElementById('datepicker-range-start');
        const dateRangeEndPicker = document.getElementById('datepicker-range-end');

        if (dateRangeStartPicker && dateRangeEndPicker) {
            // Remove existing event listeners to prevent duplicates
            dateRangeStartPicker.removeEventListener('changeDate', this.handleDateChange);
            dateRangeEndPicker.removeEventListener('changeDate', this.handleDateChange);

            // Reinitialize date picker components if they have an init method
            if (typeof window.initDatePicker === 'function') {
                window.initDatePicker('#datepicker-range-start');
                window.initDatePicker('#datepicker-range-end');
            }

            // Store reference to current DataTable for reloading
            const currentTable = $('#data-table').DataTable();
            
            // Add fresh event listeners
            dateRangeStartPicker.addEventListener('changeDate', (e) => {
                this.selectedStartDate = e.detail.date;
                this.reloadDataTable(currentTable);
            });

            dateRangeEndPicker.addEventListener('changeDate', (e) => {
                this.selectedEndDate = e.detail.date;
                this.reloadDataTable(currentTable);
            });
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
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        }
        history.pushState({}, '', url);
    },

    scrollToHash(hash, delay = 100) {
        if (!hash) return;
        
        setTimeout(() => {
            const targetElement = document.querySelector(hash);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        }, delay);
    },

    // Enhanced page content loading with proper cleanup
    async loadPageContent(url) {
        try {
            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const html = await response.text();
            const container = document.getElementById('main-content');
            
            // Clean up any existing components before loading new content
            this.cleanupComponents();
            
            container.innerHTML = html;

            // Initialize components for the new page
            const pageType = this.getPageType(url);
            if (pageType) {
                // Add a small delay to ensure DOM is fully rendered
                setTimeout(() => {
                    this.initDataTable(pageType);
                }, 50);
            } else {
                // Still initialize date pickers even if no DataTable
                setTimeout(() => {
                    this.initDatePickers();
                }, 50);
            }

            const hash = new URL(url).hash;
            this.scrollToHash(hash);

            return true;
        } catch (error) {
            console.error('Failed to load page content:', error);
            return false;
        }
    },

    // Add cleanup method
    cleanupComponents() {
        // Destroy existing DataTable
        if ($.fn.DataTable.isDataTable('#data-table')) {
            $('#data-table').DataTable().destroy();
        }

        // Clear date picker references
        this.selectedStartDate = null;
        this.selectedEndDate = null;

        // Clean up any other components that might interfere
        const datePickerElements = document.querySelectorAll('.datepicker');
        datePickerElements.forEach(element => {
            // Remove any existing event listeners or cleanup date picker instances
            if (element._datepicker && typeof element._datepicker.destroy === 'function') {
                element._datepicker.destroy();
            }
        });
    }
};

// Event Handlers
const EventHandlers = {
    // Handle menu link clicks with better event handling
    handleMenuClick(e) {
        const link = e.target.closest('.menu-link');
        if (!link) return;

        e.preventDefault();
        e.stopPropagation(); // Prevent event bubbling
        
        const url = link.href;
        const newTitle = link.getAttribute('data-title');

        // Handle hash-only changes
        if (Utils.isHashOnlyChange(url)) {
            Utils.handleHashNavigation(url);
            return;
        }

        // Load new page content
        Utils.loadPageContent(url).then(success => {
            if (success) {
                if (newTitle) {
                    document.title = newTitle;
                }
                history.pushState({}, '', url);
            }
        });
    },

    // Handle browser back/forward navigation
    handlePopState() {
        const url = location.href;
        
        // Handle hash-only changes
        if (Utils.isHashOnlyChange(url, document.referrer)) {
            const hash = new URL(url).hash;
            Utils.scrollToHash(hash);
            return;
        }

        // Load page content
        Utils.loadPageContent(url);
    },

    // Handle initial page load
    handleDOMContentLoaded() {
        const pageType = Utils.getPageType(location.href);
        if (pageType) {
            Utils.initDataTable(pageType);
        } else {
            // Initialize date pickers even if no DataTable
            Utils.initDatePickers();
        }

        // Handle initial hash
        Utils.scrollToHash(window.location.hash);
    },

    // Handle window load
    handleWindowLoad() {
        const loader = document.getElementById('loader');
        const mainContent = document.getElementById('main-content');
        
        if (loader) loader.classList.add('hidden');
        if (mainContent) mainContent.classList.remove('hidden');
    }
};

// Initialize Event Listeners with proper delegation
document.body.addEventListener('click', EventHandlers.handleMenuClick, true); // Use capture phase
window.addEventListener('popstate', EventHandlers.handlePopState);
document.addEventListener('DOMContentLoaded', EventHandlers.handleDOMContentLoaded);
window.addEventListener('load', EventHandlers.handleWindowLoad);
    </script>
</body>
</html>