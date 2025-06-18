<div>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">

                <a href="{{ route('laporan.keuangan.index') }}"
                class="inline-flex items-center text-sm text-gray-700 hover:text-blue-600 transition-colors duration-200 mb-4 menu-link" data-title="Laporan Keuangan">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>

                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Detail Kas Ledger</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-800 dark:text-gray-100">
                    <div>
                        <p class="text-sm font-semibold">Tanggal</p>
                        <p>{{ \Carbon\Carbon::parse($kasLedger->tanggal)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Outlet</p>
                        <p>{{ $kasLedger->outlet->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold">Tipe</p>
                        @php
                            $type = strtolower($kasLedger->tipe);
                            $typeClass = in_array($type, ['expense', 'transfer_out']) 
                                ? 'text-red-600 dark:text-red-400' 
                                : 'text-green-600 dark:text-green-400';
                        @endphp
                        <p class="uppercase {{ $typeClass }}">{{ $kasLedger->tipe }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Sumber</p>
                        <p>{{ $kasLedger->sumber ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold">Deskripsi</p>
                        <p>{{ $kasLedger->deskripsi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Jumlah</p>
                        @php
                            $type = strtolower($kasLedger->tipe);
                            $amountClass = in_array($type, ['expense', 'transfer_out']) 
                                ? 'text-red-600 dark:text-red-400' 
                                : 'text-green-600 dark:text-green-400';
                        @endphp
                        <p class="{{ $amountClass }}">Rp {{ number_format($kasLedger->amount, 0, ',', '.') }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold">Saldo Setelah Transaksi</p>
                        <p class="text-blue-600 dark:text-blue-400">Rp {{ number_format($kasLedger->saldo_setelah, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('laporan.keuangan.index') }}"
                       class="inline-block px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600 transition menu-link">← Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>