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
        <link rel="icon" type="image/png" href="{{ asset('images/fintory.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
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

                    <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                        @if (session('error'))
                            <div id="alert-error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">Terjadi Kesalahan!</strong>
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif
                        @if (session('success'))
                            <div id="alert-success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">Sukses!</strong>
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                    </div> -->

                    <main id="main-content" class="hidden">
                        {!! $slot !!}
                    </main>

                </div>
            </div>
            

        <script>
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
                                const pathname = window.location.pathname;
                                if(pathname == '/dashboard'){
                                    EventHandlers.handleDashboardRefresh();
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
        </script>

        <script>
            $(document).ready(function() {
                $(document).on('click', '.delete-btn, .toggle-status-product-btn, .reset-password, .swal-btn', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const $button = $(this);
                    const url = $button.data('url');
                    const action = $button.data('action') || 'delete';
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
                    } else if (action === 'reset-password') {
                        config.text = "Password user akan di reset menjadi '12345'.";
                        config.confirmText = 'Ya, Reset Password!';
                        config.successMessage = 'Password user berhasil di reset.';
                        config.errorMessage = 'Gagal melakukan reset password.';
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
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire(
                                            'Berhasil!',
                                            response.message || config.successMessage,
                                            'success'
                                        );
                                        if (window.dataTable) {
                                            window.dataTable.draw(false);
                                        } else if (typeof $('#data-table').DataTable ===
                                            'function') {
                                            $('#data-table').DataTable().ajax.reload(null,
                                                false);
                                        }
                                    } else if (response.requiresConfirmation) {
                                        Swal.fire({
                                            title: 'Data Terkait Ditemukan!',
                                            text: response.message ||
                                                'Data ini memiliki relasi. Hapus semua data yang terkait?',
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
                                                        'X-CSRF-TOKEN': $(
                                                            'meta[name="csrf-token"]'
                                                            ).attr(
                                                            'content')
                                                    },
                                                    data: {
                                                        id: id,
                                                        force: true // Kirim ulang dengan force delete
                                                    },
                                                    success: function(res) {
                                                        Swal.fire(
                                                            'Berhasil!',
                                                            res
                                                            .message,
                                                            'success'
                                                            );
                                                        if (window
                                                            .dataTable
                                                            ) {
                                                            window
                                                                .dataTable
                                                                .draw(
                                                                    false
                                                                    );
                                                        } else if (
                                                            typeof $(
                                                                '#data-table'
                                                                )
                                                            .DataTable ===
                                                            'function'
                                                            ) {
                                                            $('#data-table')
                                                                .DataTable()
                                                                .ajax
                                                                .reload(
                                                                    null,
                                                                    false
                                                                    );
                                                        }
                                                    },
                                                    error: function() {
                                                        Swal.fire(
                                                            'Error!',
                                                            'Gagal menghapus secara paksa.',
                                                            'error');
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
                                error: function(xhr) {
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

        {{-- <script>
            setTimeout(() => {
                ['alert-success', 'alert-error'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.classList.add('transition', 'opacity-0');
                        setTimeout(() => el.remove(), 1000);
                    }
                });
            }, 5000);
        </script> --}}

        @stack('scripts')
    </body>
</html>
