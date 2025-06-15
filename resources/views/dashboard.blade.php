<x-admin-layout>
    <div class="my-12 px-4">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 bg-white p-2 rounded-xl">
            <!-- Penjualan Hari Ini -->
            <div class="bg-emerald-500/90 text-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold">Penjualan Hari Ini</h3>
                <p class="text-2xl mt-2 font-bold">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            </div>

            <!-- Transaksi Hari Ini -->
            <div class="bg-sky-500/90 text-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold">Transaksi Hari Ini</h3>
                <p class="text-2xl mt-2 font-bold">{{ $totalTransaction }}</p>
            </div>

            <!-- Produk Aktif -->
            <div class="bg-indigo-500/90 text-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold">Produk Aktif</h3>
                <p class="text-2xl mt-2 font-bold">{{ $activeProductTotal }}</p>
            </div>

            <!-- Stok Kritis -->
            <div class="bg-rose-500/90 text-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold">Stok Kritis (&lt;10)</h3>
                <p class="text-2xl mt-2 font-bold">{{ $lowProductTotal }}</p>
            </div>

            <div>
                <div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
                    <div class="flex justify-between">
                        <div>
                            <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">
                                {{ number_format($totalSalesLast7Days, 0, ',', '.') }}
                            </h5>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Penjualan dalam 7 hari terakhir</p>
                        </div>
                    </div>
                    <div id="area-chart"></div>
                    <div
                        class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                        <div class="flex justify-between items-center pt-5">
                            <!-- Button -->
                            <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown"
                                data-dropdown-placement="bottom"
                                class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                                type="button">
                                Last 7 days
                                <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="lastDaysdropdown"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownDefaultButton">
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                            7 days</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                            30 days</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                            90 days</a>
                                    </li>
                                </ul>
                            </div>
                            <a href="#"
                                class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                                Users Report
                                <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
